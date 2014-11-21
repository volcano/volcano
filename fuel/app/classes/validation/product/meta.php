<?php

/**
 * Validation product meta class.
 */
class Validation_Product_Meta
{
	/**
	 * Creates a new validation instance for product meta create.
	 *
	 * @return Validation
	 */
	public static function create()
	{
		$validator = Validation::forge('product_meta');
		
		$validator->add('name', 'Name')->add_rule('trim')->add_rule('required');
		
		return $validator;
	}
	
	/**
	 * Creates a new validation instance for product meta update.
	 *
	 * @return Validation
	 */
	public static function update()
	{
		$validator = Validation::forge('product_meta');
		
		$input = Input::param();
		
		if (array_key_exists('name', $input)) {
			$validator->add('name', 'Name')->add_rule('trim')->add_rule('required');
		}
		
		return $validator;
	}
}
