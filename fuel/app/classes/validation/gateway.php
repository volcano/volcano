<?php

/**
 * Validation Gateway class.
 *
 * @author Keithia Stegmann <kstegmann@static.com>
 */
class Validation_Gateway
{
	/**
	 * Allowed gateway types.
	 *
	 * @var array
	 */
	protected static $types = array(
		'credit_card',
	);
	
	/**
	 * Allowed gateway processors.
	 *
	 * @var array
	 */
	protected static $processors = array(
		'authorizenet',
	);
	
	/**
	 * Creates a new validation instance for gateway create.
	 *
	 * @return Validation
	 */
	public static function create()
	{
		$validator = Validation::forge('gateway');
		
		$validator->add('type', 'Type')->add_rule('trim')->add_rule('valid_value', self::$types);
		$validator->add('processor', 'Processor')->add_rule('trim')->add_rule('valid_value', self::$processors);
		$validator->add('meta', 'Meta Data')->add_rule('required');
		
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
			$validator->add('type', 'Type')->add_rule('trim')->add_rule('valid_value', self::$types);
		}
		
		if (array_key_exists('processor', $input)) {
			$validator->add('processor', 'Processor')->add_rule('trim')->add_rule('valid_value', self::$processors);
		}
		
		if (array_key_exists('meta', $input)) {
			$validator->add('meta', 'Meta Data');
		}
		
		return $validator;
	}
}
