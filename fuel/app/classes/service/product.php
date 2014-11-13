<?php

/**
 * Product service.
 */
class Service_Product extends Service
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
		
		$products = Model_Product::query();
		
		if (!empty($options['id'])) {
			$products->where('id', $options['id']);
		}
		
		if (!empty($options['seller'])) {
			$products->where('seller_id', $options['seller']->id);
		}
		
		if (!empty($options['status'])) {
			$products->where('status', $options['status']);
		}
		
		return $products;
	}
	
	/**
	 * Creates a new product.
	 *
	 * @param string        $name   The name of the product.
	 * @param Model_Seller  $seller The seller the product belongs to.
	 * @param array         $data   Optional data.
	 *
	 * @return Model_Product
	 */
	public static function create($name, Model_Seller $seller, array $data = array())
	{
		$product = Model_Product::forge();
		$product->name = $name;
		$product->seller = $seller;
		
		$product->populate($data);
		
		try {
			$product->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		Service_Event::trigger('product.create', $product->seller, $product->to_array());
		
		return $product;
	}
	
	/**
	 * Updates a product.
	 *
	 * @param Model_Product $product The product to update.
	 * @param array         $data    The data to use to update the product.
	 *
	 * @return Model_Product
	 */
	public static function update(Model_Product $product, array $data = array())
	{
		$product->populate($data);
		
		try {
			$product->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		Service_Event::trigger('product.update', $product->seller, $product->to_array());
		
		return $product;
	}
	
	/**
	 * Deletes a product.
	 *
	 * @param Model_Product $product The product to delete.
	 *
	 * @return bool
	 */
	public static function delete(Model_Product $product)
	{
		$product->status = 'deleted';
		
		try {
			$product->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		Service_Event::trigger('product.delete', $product->seller, $product->to_array());
		
		return true;
	}
}
