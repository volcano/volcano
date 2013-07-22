<?php

/**
 * Validation Gateway class.
 *
 * @author Keithia Stegmann <kstegmann@static.com>
 */
class Validation_Gateway
{
	/**
	 * Creates a new validation instance for gateway create.
	 *
	 * @return Validation
	 */
	public static function create()
	{
		$validator = Validation::forge('gateway');
		
		$validator->add('type', 'Type')->add_rule('trim')->add_rule('required');
		$validator->add('processor', 'Processor')->add_rule('trim')->add_rule('required');
		$validator->add('meta', 'Meta Data');
		
		return $validator;
	}
	
	/**
	 * Creates a new validation instance for gateway update.
	 *
	 * @return Validation
	 */
	public static function update()
	{
		$validator = Validation::forge('gateway');
		
		$input = Input::param();
		
		if (array_key_exists('type', $input)) {
			$validator->add('type', 'Type')->add_rule('trim')->add_rule('required');
		}
		
		if (array_key_exists('processor', $input)) {
			$validator->add('processor', 'Processor')->add_rule('trim')->add_rule('required');
		}
		
		if (array_key_exists('meta', $input)) {
			$validator->add('meta', 'Meta Data');
		}
		
		return $validator;
	}
}
