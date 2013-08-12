<?php

/**
 * Customer product option service.
 *
 * @author Keithia Stegmann <kstegmann@static.com>
 */
class Service_Customer_Product_Option extends Service
{
	/**
	 * Query models based on optional filters passed in.
	 *
	 * @param array $args The optional data to use.
	 *
	 * @return Query
	 */
	protected static function query(array $args = array())
	{
		$args = array_merge(array(
			'status' => 'active',
		), $args);
		
		$options = Model_Customer_Product_Option::query();
		
		if (!empty($args['id'])) {
			$options->where('id', $args['id']);
		}
		
		if (!empty($args['customer'])) {
			$options->where('customer_id', $args['customer']->id);
		}
		
		if (!empty($args['status'])) {
			$options->where('status', $args['status']);
		}
		
		return $options;
	}
	
	/**
	 * Creates a new customer product option.
	 *
	 * @param string               $name     The name of the customer product option.
	 * @param Model_Customer       $customer The customer the customer product option belongs to.
	 * @param Model_Product_Option $option   The option the customer product option belongs to.
	 * @param array                $data     Optional data.
	 *
	 * @return Model_Customer_Product_Option
	 */
	public static function create($name, Model_Customer $customer, Model_Product_Option $option, array $data = array())
	{
		$option = Model_Customer_Product_Option::forge();
		$option->name = $name;
		$option->customer = $customer;
		$option->product = $product;
		
		$option->populate($data);
		
		try {
			$option->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $option;
	}
	
	/**
	 * Updates a customer product option.
	 *
	 * @param Model_Customer_Product_Option $option The customer product option to update.
	 * @param array                         $data   The data to use to update the customer product option.
	 *
	 * @return Model_Customer_Product_Option
	 */
	public static function update(Model_Customer_Product_Option $option, array $data = array())
	{
		$option->populate($data);
		
		try {
			$option->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $option;
	}
	
	/**
	 * Deletes a customer product option.
	 *
	 * @param Model_Customer_Product_Option $option The customer product option to delete.
	 *
	 * @return bool
	 */
	public static function delete(Model_Customer_Product_Option $option)
	{
		$option->status = 'deleted';
		
		try {
			$option->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
}
