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
		
		if (!empty($options['status'])) {
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
		
		$payment_method = Model_Customer_Paymentmethod::forge();
		$payment_method->customer = $customer;
		$payment_method->contact  = $contact;
		$payment_method->gateway  = $gateway;
		
		$gateway_payment_method = \Gateway::instance($gateway, $customer)->paymentmethod()->create(array(
			'account' => $account,
			'contact' => $contact,
		));
		
		if (!$gateway_payment_method) {
			return false;
		}
		
		$payment_method->external_id = $gateway_payment_method;
		
		if (Arr::get($data, 'default')) {
			$payment_method->default = 1;
		}
		
		try {
			$payment_method->save();
		} catch (FuelException $e) {
			dar($e);die;
			Log::error($e);
			return false;
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
}
