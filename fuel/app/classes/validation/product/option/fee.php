<?php

/**
 * Validation product option fee class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Validation_Product_Option_Fee
{
	/**
	 * Creates a new validation instance for product option fee create.
	 *
	 * @return Validation
	 */
	public static function create()
	{
		$validator = Validation::forge('product_option_fee');
		
		$validator->add('interval', 'Interval')->add_rule('required');
		$validator->add('interval_unit', 'Interval Unit')->add_rule('required');
		$validator->add('interval_price', 'Interval Price')->add_rule('required');
		
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
		
		if (array_key_exists('interval', $input)) {
			$validator->add('interval', 'Interval')->add_rule('required');
		}
		
		if (array_key_exists('interval_unit', $input)) {
			$validator->add('interval_unit', 'Interval Unit')->add_rule('required');
		}
		
		if (array_key_exists('interval_price', $input)) {
			$validator->add('interval_price', 'Interval Price')->add_rule('required');
		}
		
		return $validator;
	}
}
