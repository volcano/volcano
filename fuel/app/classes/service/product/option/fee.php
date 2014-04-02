<?php

/**
 * Product option fee service.
 */
class Service_Product_Option_Fee extends Service
{
	/**
	 * Query models based on optional filters passed in.
	 *
	 * @param array $options The optional data to use.
	 *
	 * @return Query
	 */
	protected static function query(array $options = array())
	{
		$options = array_merge(array(
			'status' => 'active',
		), $options);
		
		$fees = Model_Product_Option_Fee::query();
		
		if (!empty($options['id'])) {
			$fees->where('id', $options['id']);
		}
		
		if (!empty($options['option'])) {
			$fees->related('option');
			$fees->where('option.id', $options['option']->id);
		}
		
		if (!empty($options['status'])) {
			$fees->where('status', $options['status']);
		}
		
		return $fees;
	}
	
	/**
	 * Creates a new product option fee.
	 *
	 * @param string               $name           The name of the product option fee.
	 * @param int                  $interval       Interval amount (1, 6, etc).
	 * @param string               $interval_unit  Interval unit (day, month, year, etc).
	 * @param float                $interval_price Interval price (5.00, 12.99, etc).
	 * @param Model_Product_Option $option         The option the fee belongs to.
	 * @param array                $data           Optional data.
	 *
	 * @return Model_Product_Option_Fee
	 */
	public static function create($name, $interval, $interval_unit, $interval_price, Model_Product_Option $option, array $data = array())
	{
		$fee = Model_Product_Option_Fee::forge();
		$fee->name           = $name;
		$fee->interval       = $interval;
		$fee->interval_unit  = $interval_unit;
		$fee->interval_price = $interval_price;
		$fee->option         = $option;
		
		$fee->populate($data);
		
		try {
			$fee->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		Service_Event::trigger('product.option.fee.create', $fee->option->product->seller, $fee->to_array());
		
		return $fee;
	}
	
	/**
	 * Updates a product option fee.
	 *
	 * @param Model_Product_Option_Fee $fee  The product option fee to update.
	 * @param array                    $data The data to use to update the product option fee.
	 *
	 * @return Model_Product_Option_Fee
	 */
	public static function update(Model_Product_Option_Fee $fee, array $data = array())
	{
		$fee->populate($data);
		
		try {
			$fee->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		Service_Event::trigger('product.option.fee.update', $fee->option->product->seller, $fee->to_array());
		
		return $fee;
	}
	
	/**
	 * Deletes a product option fee.
	 *
	 * @param Model_Product_Option_Fee $fee The product option fee to delete.
	 *
	 * @return bool
	 */
	public static function delete(Model_Product_Option_Fee $fee)
	{
		$fee->status = 'deleted';
		
		try {
			$fee->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		Service_Event::trigger('product.option.fee.delete', $fee->option->product->seller, $fee->to_array());
		
		return true;
	}
}
