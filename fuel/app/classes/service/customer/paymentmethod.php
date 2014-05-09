<?php

/**
 * Customer payment method service.
 */
class Service_Customer_Paymentmethod extends Service
{
	/**
	 * Query models based on optional filters passed in.
	 *
	 * @param array $options The optional options to use.
	 *
	 * @return Query
	 */
	protected static function query(array $options = array())
	{
		$options = array_merge(array(
			'status' => 'active',
		), $options);
		
		$payment_methods = Model_Customer_Paymentmethod::query();
		
		if (!empty($options['id'])) {
			$payment_methods->where('id', $options['id']);
		}
		
		if (!empty($options['customer'])) {
			$payment_methods->where('customer_id', $options['customer']->id);
		}
		
		if (!empty($options['gateway'])) {
			$payment_methods->where('gateway_id', $options['gateway']->id);
		}
		
		if (!empty($options['primary'])) {
			$payment_methods->where('primary', $options['primary']);
		}
		
		if (!empty($options['status']) && $options['status'] != 'all') {
			$payment_methods->where('status', $options['status']);
		}
		
		return $payment_methods;
	}
	
	/**
	 * Creates a new payment method.
	 *
	 * @param Model_Customer $customer The customer the payment method belongs to.
	 * @param array          $data   Optional data.
	 *
	 * @return Model_Customer_Paymentmethod
	 */
	public static function create(Model_Customer $customer, Model_Gateway $gateway, array $data = array())
	{
		if (!$account = Arr::get($data, 'account')) {
			return false;
		}
		
		if (!$contact = Arr::get($data, 'contact')) {
			return false;
		}
		
		// Find or create the payment method's contact.
		if (is_numeric($contact)) {
			$contact = Service_Contact::find_one($contact);
		} elseif (is_array($contact)) {
			$contact = Service_Contact::create($contact);
		}
		
		if (!$contact) {
			return false;
		}
		
		$payment_method = Model_Customer_Paymentmethod::forge();
		$payment_method->customer    = $customer;
		$payment_method->contact     = $contact;
		$payment_method->gateway     = $gateway;
		$payment_method->provider    = Arr::get($data, 'account.provider');
		$payment_method->account     = '****' . substr(Arr::get($data, 'account.number'), -4);
		
		$gateway_instance = Gateway::instance($gateway, $customer);
		if ($gateway_instance) {
			$gateway_payment_method_id = $gateway_instance->paymentmethod()->create(array(
				'account' => $account,
				'contact' => $contact,
			));
			
			if (!$gateway_payment_method_id) {
				return false;
			}
			
			$gateway_payment_method = $gateway_instance->paymentmethod($gateway_payment_method_id);
			
			$payment_method->external_id = $gateway_payment_method->data('id');
		}
		
		try {
			$payment_method->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		// Set as primary if customer has none.
		$primary = self::primary($customer);
		if (Arr::get($data, 'primary') || empty($primary)) {
			self::set_primary($payment_method);
		}
		
		Service_Event::trigger(
			'customer.paymentmethod.create',
			$payment_method->customer->seller,
			$payment_method->to_array()
		);
		
		return $payment_method;
	}
	
	/**
	 * Updates a payment method.
	 *
	 * @param Model_Customer_Paymentmethod $payment_method The payment method to update.
	 * @param array                        $data           The data to use to update the payment method.
	 *
	 * @return Model_Customer_Paymentmethod
	 */
	public static function update(Model_Customer_Paymentmethod $payment_method, array $data = array())
	{
		if (!$account = Arr::get($data, 'account')) {
			return false;
		}
		
		if (!$contact = Arr::get($data, 'contact')) {
			return false;
		}
		
		if (is_numeric($contact)) {
			$contact = Service_Contact::find_one($contact);
			if (!$contact) {
				return false;
			}
			
			$data['contact'] = $contact;
		}
		
		$gateway  = $payment_method->gateway;
		$customer = $payment_method->customer;
		
		$gateway_instance = Gateway::instance($gateway, $customer);
		if ($gateway_instance) {
			$gateway_payment_method = $gateway_instance->paymentmethod($payment_method->external_id);
			if (!$gateway_payment_method) {
				return false;
			}
			
			$updated = $gateway_payment_method->update($data);
			if (!$updated) {
				return false;
			}
			
			$gateway_payment_method  = $gateway_instance->paymentmethod($payment_method->external_id);
			$payment_method->account = $gateway_payment_method->data('account');
		}
		
		// Update the model.
		$payment_method->provider = Arr::get($account, 'provider');
		
		if ($contact instanceof Model_Contact) {
			$payment_method->contact = $contact;
		} else {
			Service_Contact::update($payment_method->contact, $contact);
		}
		
		try {
			$payment_method->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		if (Arr::get($data, 'primary')) {
			self::set_primary($payment_method);
		}
		
		Service_Event::trigger(
			'customer.paymentmethod.update',
			$payment_method->customer->seller,
			$payment_method->to_array()
		);
		
		return $payment_method;
	}
	
	/**
	 * Deletes a payment method.
	 *
	 * @param Model_Customer_Paymentmethod $payment_method The payment method to delete.
	 *
	 * @return bool
	 */
	public static function delete(Model_Customer_Paymentmethod $payment_method)
	{
		// A primary payment method cannot be deleted.
		if ($payment_method->primary()) {
			return false;
		}
		
		$gateway  = $payment_method->gateway;
		$customer = $payment_method->customer;
		
		$gateway_instance = Gateway::instance($gateway, $customer);
		if ($gateway_instance) {
			$gateway_payment_method = $gateway_instance->paymentmethod($payment_method->external_id);
			if (!$gateway_payment_method) {
				return false;
			}
			
			if (!$gateway_payment_method->delete()) {
				return false;
			}
		}
		
		$payment_method->status = 'deleted';
		
		try {
			$payment_method->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		Service_Event::trigger(
			'customer.paymentmethod.delete',
			$payment_method->customer->seller,
			$payment_method->to_array()
		);
		
		return true;
	}
	
	/**
	 * Gets a customer's primary payment method.
	 *
	 * @param Model_Customer $customer The customer.
	 *
	 * @return Model_Customer_Paymentmethod
	 */
	public static function primary(Model_Customer $customer)
	{
		return self::find_one(array(
			'customer' => $customer,
			'primary'  => true,
		));
	}
	
	/**
	 * Sets a customer's primary payment method.
	 *
	 * @param Model_Customer_Paymentmethod $new Primary payment method.
	 * 
	 * @return bool
	 */
	protected static function set_primary(Model_Customer_Paymentmethod $new)
	{
		$existing = self::primary($new->customer);
		if ($existing) {
			$existing->primary = null;
			
			try {
				$existing->save();
			} catch (FuelException $e) {
				Log::error($e);
				return false;
			}
		}
		
		$new->primary = 1;
		
		try {
			$new->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
}
