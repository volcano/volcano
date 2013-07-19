<?php

/**
 * Validation Customer class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Validation_Customer
{
	/**
	 * Creates a new validation instance for customer create.
	 *
	 * @return Validation
	 */
	public static function create()
	{
		$validator = Validation::forge('customer');
		
		$validator->add('contact', 'Contact')->add_rule('required');
		$validator->add('balance', 'Balance')->add_rule('trim');
		
		return $validator;
	}
	
	/**
	 * Creates a new validation instance for customer update.
	 *
	 * @return Validation
	 */
	public static function update()
	{
		$validator = Validation::forge('customer');
		
		$input = Input::param();
		
		if (array_key_exists('balance', $input)) {
			$validator->add('balance', 'Balance')->add_rule('trim');
		}
		
		return $validator;
	}
}