<?php

/**
 * Customer gateway service.
 */
class Service_Customer_Gateway extends Service
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
		$gateways = Model_Customer_Gateway::query();
		
		if (!empty($options['id'])) {
			$gateways->where('id', $options['id']);
		}
		
		if (!empty($options['customer'])) {
			$gateways->where('customer_id', $options['customer']->id);
		}
		
		if (!empty($options['gateway'])) {
			$gateways->where('gateway_id', $options['gateway']->id);
		}
		
		return $gateways;
	}
	
	/**
	 * Creates a new customer gateway relation.
	 *
	 * @param Model_Customer $customer The customer.
	 * @param Model_Gateway  $gateway  The gateway.
	 * @param array          $data     Optional data.
	 *
	 * @return Model_Customer
	 */
	public static function create(Model_Customer $customer, Model_Gateway $gateway, array $data = array())
	{
		if (!$contact = Arr::get($data, 'contact')) {
			$contact = current($customer->contacts);
		}
		
		$external_id = Gateway::instance($gateway)->customer()->create(array(
			'customer' => $customer,
			'contact'  => $contact,
		));
		
		if (!$external_id) {
			return false;
		}
		
		$customer_gateway = Model_Customer_Gateway::forge();
		$customer_gateway->customer_id = $customer->id;
		$customer_gateway->gateway_id  = $gateway->id;
		$customer_gateway->external_id = $external_id;
		
		try {
			$customer_gateway->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $customer_gateway;
	}
	
	/**
	 * Gets the external_id for a customer and gateway relation.
	 *
	 * @param Model_Customer $customer The customer.
	 * @param Model_Gateway  $gateway  The gateway.
	 *
	 * @return int
	 */
	public static function external_id(Model_Customer $customer, Model_Gateway $gateway)
	{
		$customer_gateway = self::find_one(array(
			'customer' => $customer,
			'gateway'  => $gateway,
		));
		
		if (!$customer_gateway) {
			$customer_gateway = self::create($customer, $gateway);
		}
		
		return $customer_gateway->external_id;
	}
}
