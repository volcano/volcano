<?php

/**
 * Validation gateway class.
 */
class Validation_Gateway
{
	/**
	 * Initializer executed when class is loaded.
	 *
	 * @return void
	 */
	public static function _init()
	{
		Config::load('gateway', true);
	}
	
	/**
	 * Creates a new validation instance for gateway create.
	 *
	 * @return Validation
	 */
	public static function create()
	{
		$validator = Validation::forge('gateway');
		
		$validator->add('type', 'Type')->add_rule('trim')->add_rule('valid_value', Config::get('gateway.types'))->add_rule('required');
		$validator->add('processor', 'Processor')->add_rule('trim')->add_rule('valid_value', Config::get('gateway.processors'))->add_rule('required');
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
			$validator->add('type', 'Type')->add_rule('trim')->add_rule('valid_value', Config::get('gateway.types'))->add_rule('required');
		}
		
		if (array_key_exists('processor', $input)) {
			$validator->add('processor', 'Processor')->add_rule('trim')->add_rule('valid_value', Config::get('gateway.processors'))->add_rule('required');
		}
		
		if (array_key_exists('meta', $input)) {
			$validator->add('meta', 'Meta Data');
		}
		
		return $validator;
	}
}
