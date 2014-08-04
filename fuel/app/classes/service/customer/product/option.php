<?php

/**
 * Customer product option service.
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
		
		if (!empty($args['status']) && $args['status'] != 'all') {
			$options->where('status', $args['status']);
		}
		
		return $options;
	}
	
	/**
	 * Creates a new customer product option.
	 *
	 * @param string               $name     The name of the customer product option.
	 * @param Model_Customer_Order $order    The order the customer product option belongs to.
	 * @param Model_Product_Option $option   The option the customer product option belongs to.
	 * @param array                $data     Optional data.
	 *
	 * @return Model_Customer_Product_Option
	 */
	public static function create($name, Model_Customer_Order $order, Model_Product_Option $option, array $data = array())
	{
		$customer_option = Model_Customer_Product_Option::forge();
		$customer_option->name = $name;
		$customer_option->customer = $order->customer;
		$customer_option->order = $order;
		$customer_option->option = $option;
		
		$customer_option->populate($data);
		
		try {
			$customer_option->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		Service_Event::trigger(
			'customer.product.option.create',
			$customer_option->customer->seller,
			$customer_option->to_array()
		);
		
		return $customer_option;
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
		
		Service_Event::trigger(
			'customer.product.option.update',
			$option->customer->seller,
			$option->to_array()
		);
		
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
		
		Service_Event::trigger(
			'customer.product.option.delete',
			$option->customer->seller,
			$option->to_array()
		);
		
		return true;
	}
}
