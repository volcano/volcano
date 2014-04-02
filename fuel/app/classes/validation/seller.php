<?php

/**
 * Validation seller class.
 */
class Validation_Seller
{
	/**
	 * Creates a new validation instance for seller create.
	 *
	 * @return Validation
	 */
	public static function create()
	{
		$validator = Validation::forge('seller');
		
		$validator->add('name', 'Name')->add_rule('trim')->add_rule('required');
		$validator->add('contact', 'Contact')->add_rule('contact', 'seller');
		
		return $validator;
	}
	
	/**
	 * Creates a new validation instance for seller update.
	 *
	 * @return Validation
	 */
	public static function update()
	{
		$validator = Validation::forge('seller');
		
		$input = Input::param();
		
		if (array_key_exists('name', $input)) {
			$validator->add('name', 'Name')->add_rule('trim')->add_rule('required');
		}
		
		return $validator;
	}
}
