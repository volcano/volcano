<?php

/**
 * Product option service.
 */
class Service_Product_Option extends Service
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
		
		$options = Model_Product_Option::query();
		
		if (!empty($args['id'])) {
			$options->where('id', $args['id']);
		}
		
		if (!empty($args['product'])) {
			$options->related('product');
			$options->where('product.id', $args['product']->id);
		}
		
		if (!empty($args['status'])) {
			$options->where('status', $args['status']);
		}
		
		return $options;
	}
	
	/**
	 * Creates a new product option.
	 *
	 * @param string        $name    The name of the product option.
	 * @param Model_Product $product The product the option belongs to.
	 * @param array         $data    Optional data.
	 *
	 * @return Model_Product_Option
	 */
	public static function create($name, Model_Product $product, array $data = array())
	{
		$option = Model_Product_Option::forge();
		$option->name = $name;
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
	 * Updates a product option.
	 *
	 * @param Model_Product_Option $option The product option to update.
	 * @param array                $data   The data to use to update the product option.
	 *
	 * @return Model_Product_Option
	 */
	public static function update(Model_Product_Option $option, array $data = array())
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
	 * Deletes a product option.
	 *
	 * @param Model_Product_Option $option The product option to delete.
	 *
	 * @return bool
	 */
	public static function delete(Model_Product_Option $option)
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
