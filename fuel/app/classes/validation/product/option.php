<?php

/**
 * Validation product option class.
 */
class Validation_Product_Option
{
	/**
	 * Creates a new validation instance for product option create.
	 *
	 * @return Validation
	 */
	public static function create()
	{
		$validator = Validation::forge('product_option');
		
		$validator->add('name', 'Name')->add_rule('trim')->add_rule('required');
		
		return $validator;
	}
	
	/**
	 * Creates a new validation instance for product option update.
	 *
	 * @return Validation
	 */
	public static function update()
	{
		$validator = Validation::forge('product_option');
		
		$input = Input::param();
		
		if (array_key_exists('name', $input)) {
			$validator->add('name', 'Name')->add_rule('trim')->add_rule('required');
		}
		
		return $validator;
	}
}
