<?php

/**
 * Customer payment method service.
 *
 * @author Daniel Sposito <dsposito@static.com>
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
		
		if (!$contact instanceof Model_Contact) {
			$contact = Service_Contact::create(
				Arr::get($contact, 'first_name'),
				Arr::get($contact, 'last_name'),
				$contact
			);
			
			if (!$contact) {
				return false;
			}
		}
		
		$gateway_instance = \Gateway::instance($gateway, $customer);
		
		$gateway_payment_method_id = $gateway_instance->paymentmethod()->create(array(
			'account' => $account,
			'contact' => $contact,
		));
		
		if (!$gateway_payment_method_id) {
			return false;
		}
		
		$gateway_payment_method = $gateway_instance->paymentmethod($gateway_payment_method_id);
		
		$payment_method = Model_Customer_Paymentmethod::forge();
		$payment_method->customer    = $customer;
		$payment_method->contact     = $contact;
		$payment_method->gateway     = $gateway;
		$payment_method->external_id = $gateway_payment_method->data('id');
		$payment_method->provider    = Arr::get($data, 'account.provider');
		$payment_method->account     = $gateway_payment_method->data('account');
		
		try {
			$payment_method->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		// Set as primary if customer has none.
		$primary = self::primary($customer, $gateway);
		if (Arr::get($data, 'primary') || empty($primary)) {
			self::set_primary($payment_method);
		}
		
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
		if (Arr::get($data, 'account') || Arr::get($data, 'contact')) {
			$gateway  = $payment_method->gateway;
			$customer = $payment_method->customer;
			
			$gateway_payment_method = \Gateway::instance($gateway, $customer)->paymentmethod($payment_method->external_id);
			if (!$gateway_payment_method) {
				return false;
			}
			
			$updated = $gateway_payment_method->update($data);
			if (!$updated) {
				return false;
			}
		}
		
		if ($contact = Arr::get($data, 'contact')) {
			$payment_method->contact->populate($contact);
			
			try {
				$payment_method->contact->save();
			} catch (FuelException $e) {
				Log::error($e);
				return false;
			}
		}
		
		if (Arr::get($data, 'primary')) {
			self::set_primary($payment_method);
		}
		
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
		$gateway  = $payment_method->gateway;
		$customer = $payment_method->customer;
		
		$gateway_payment_method = \Gateway::instance($gateway, $customer)->paymentmethod($payment_method->external_id);
		if (!$gateway_payment_method) {
			return false;
		}
		
		if (!$gateway_payment_method->delete()) {
			return false;
		}
		
		$payment_method->status = 'deleted';
		
		try {
			$payment_method->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
	
	/**
	 * Gets a customer's primary payment method for a gateway.
	 *
	 * @param Model_Customer $customer The customer.
	 * @param Model_Gateway  $gateway  The gateway.
	 *
	 * @return Model_Customer_Paymentmethod
	 */
	public static function primary(Model_Customer $customer, Model_Gateway $gateway)
	{
		return self::find_one(array(
			'customer' => $customer,
			'gateway'  => $gateway,
			'primary'  => true,
		));
	}
	
	/**
	 * Sets a customer's primary payment method for a gateway.
	 *
	 * @param Model_Customer_Paymentmethod $new Primary payment method.
	 * 
	 * @return bool
	 */
	protected static function set_primary(Model_Customer_Paymentmethod $new)
	{
		$existing = self::primary($new->customer, $new->gateway);
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
