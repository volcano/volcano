<?php

/**
 * Product meta option service.
 */
class Service_Product_Meta_Option extends Service
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
		$options = Model_Product_Meta_Option::query();
		
		if (!empty($args['id'])) {
			$options->where('id', $args['id']);
		}
		
		if (!empty($args['meta'])) {
			$options->related('meta');
			$options->where('meta.id', $args['meta']->id);
		}
		
		return $options;
	}
	
	/**
	 * Creates a new product meta option.
	 *
	 * @param mixed                $value The meta option value.
	 * @param Model_Product_Meta   $meta  The product meta the option belongs to.
	 *
	 * @return Model_Product_Meta_Option
	 */
	public static function create($value, Model_Product_Meta $meta)
	{
		$option = Model_Product_Meta_Option::forge();
		$option->value = $value;
		$option->meta  = $meta;
		
		try {
			$option->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		Service_Event::trigger('product.meta.option.create', $option->meta->product->seller, $option->to_array());
		
		return $option;
	}
	
	/**
	 * Updates a product meta option.
	 *
	 * @param Model_Product_Meta_Option $option The product meta option to update.
	 * @param array                     $data   The data to use to update the product meta option.
	 *
	 * @return Model_Product_Meta_Option
	 */
	public static function update(Model_Product_Meta_Option $option, array $data = array())
	{
		$option->populate($data);
		
		try {
			$option->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		Service_Event::trigger('product.meta.option.update', $option->meta->product->seller, $option->to_array());
		
		return $option;
	}
}
