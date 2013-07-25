<?php

/**
 * Customer service.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Service_Customer extends Service
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
		
		$customers = Model_Customer::query();
		
		if (!empty($options['id'])) {
			$customers->where('id', $options['id']);
		}
		
		if (!empty($options['seller'])) {
			$customers->where('seller_id', $options['seller']->id);
		}
		
		if (!empty($options['status'])) {
			$customers->where('status', $options['status']);
		}
		
		return $customers;
	}
	
	/**
	 * Creates a new customer.
	 *
	 * @param Model_Seller  $seller The seller the customer belongs to.
	 * @param array         $data   Optional data.
	 *
	 * @return Model_Customer
	 */
	public static function create(Model_Seller $seller, array $data = array())
	{
		if (!$contact_data = Arr::get($data, 'contact')) {
			return false;
		}
		
		$customer = Model_Customer::forge();
		$customer->seller = $seller;
		
		$customer->populate($data);
		
		try {
			$customer->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		$contact = \Service_Contact::create(
			Arr::get($contact_data, 'first_name'),
			Arr::get($contact_data, 'last_name'),
			$contact_data
		);
		
		if (!$contact || !Service_Contact::link($contact, $customer)) {
			return false;
		}
		
		return $customer;
	}
	
	/**
	 * Updates a customer.
	 *
	 * @param Model_Customer $customer The customer to update.
	 * @param array          $data     The data to use to update the customer.
	 *
	 * @return Model_Customer
	 */
	public static function update(Model_Customer $customer, array $data = array())
	{
		$customer->populate($data);
		
		try {
			$customer->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $customer;
	}
	
	/**
	 * Deletes a customer.
	 *
	 * @param Model_Customer $customer The customer to delete.
	 *
	 * @return bool
	 */
	public static function delete(Model_Customer $customer)
	{
		$customer->status = 'deleted';
		
		try {
			$customer->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
}
