<?php

/**
 * Validation product option fee class.
 */
class Validation_Product_Option_Fee
{
	/**
	 * Initializer executed when class is loaded.
	 *
	 * @return void
	 */
	public static function _init()
	{
		Config::load('fee', true);
	}
	
	/**
	 * Creates a new validation instance for product option fee create.
	 *
	 * @return Validation
	 */
	public static function create()
	{
		$validator = Validation::forge('product_option_fee');
		
		$validator->add('name', 'Name')->add_rule('trim')->add_rule('required');
		$validator->add('interval', 'Interval')->add_rule('trim')->add_rule('valid_value', Config::get('fee.intervals'))->add_rule('required');
		$validator->add('interval_unit', 'Interval Unit')->add_rule('trim')->add_rule('valid_value', Config::get('fee.interval_units'))->add_rule('required');
		$validator->add('interval_price', 'Interval Price')->add_rule('trim')->add_rule('valid_string', 'float')->add_rule('required');
		
		return $validator;
	}
	
	/**
	 * Creates a new validation instance for product option fee update.
	 *
	 * @return Validation
	 */
	public static function update()
	{
		$validator = Validation::forge('product_option_fee');
		
		$input = Input::param();
		
		if (array_key_exists('name', $input)) {
			$validator->add('name', 'Name')->add_rule('trim')->add_rule('required');
		}
		
		if (array_key_exists('interval', $input)) {
			$validator->add('interval', 'Interval')->add_rule('trim')->add_rule('valid_value', Config::get('fee.intervals'))->add_rule('required');
		}
		
		if (array_key_exists('interval_unit', $input)) {
			$validator->add('interval_unit', 'Interval Unit')->add_rule('trim')->add_rule('valid_value', Config::get('fee.interval_units'))->add_rule('required');
		}
		
		if (array_key_exists('interval_price', $input)) {
			$validator->add('interval_price', 'Interval Price')->add_rule('valid_string', 'float')->add_rule('trim')->add_rule('required');
		}
		
		return $validator;
	}
}
