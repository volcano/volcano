<?php

/**
 * Validation Seller class.
 *
 * @author Daniel Sposito <dsposito@static.com>
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
		$validator = Validation::forge();
		
		$validator->add('name', 'Name')->add_rule('trim')->add_rule('required');
		$validator->add('contact_id', 'Contact ID')->add_rule('trim')->add_rule('valid_string', 'integer')->add_rule('required');
		
		return $validator;
	}
	
	/**
	 * Creates a new validation instance for seller update.
	 *
	 * @return Validation
	 */
	public static function update()
	{
		$validator = Validation::forge();
		
		$input = Input::all();
		
		if (array_key_exists('name', $input)) {
			$validator->add('name', 'Name')->add_rule('trim')->add_rule('required');
		}
		
		return $validator;
	}
}
