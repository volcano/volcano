<?php

/**
 * Validation Contact class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Validation_Contact
{
	/**
	 * Creates a new validation instance for contact create.
	 *
	 * @return Validation
	 */
	public static function create()
	{
		$validator = Validation::forge();
		
		$validator->add('first_name', 'First Name')->add_rule('trim')->add_rule('required');
		$validator->add('last_name', 'Last Name')->add_rule('trim')->add_rule('required');
		$validator = self::add_optional_fields($validator);
		
		return $validator;
	}
	
	/**
	 * Creates a new validation instance for contact update.
	 *
	 * @return Validation
	 */
	public static function update()
	{
		$validator = Validation::forge();
		
		$input = Input::put();
		
		if (array_key_exists('first_name', $input)) {
			$validator->add('first_name', 'First Name')->add_rule('trim')->add_rule('required');;
		}
		
		if (array_key_exists('last_name', $input)) {
			$validator->add('last_name', 'Last Name')->add_rule('trim')->add_rule('required');
		}
		
		$validator = self::add_optional_fields($validator);
		
		return $validator;
	}
	
	/**
	 * Adds optional fields to a Validation object.
	 *
	 * @param Validation $validator Validation object.
	 * 
	 * @return Validation
	 */
	protected static function add_optional_fields($validator)
	{
		$fields = array(
			'company_name',
			'address',
			'address2',
			'city',
			'state',
			'zip',
			'country',
			'phone',
			'fax',
		);
		
		$input = Input::all();
		
		foreach ($fields as $field) {
			if (array_key_exists($field, $input)) {
				$validator->add($field, Inflector::humanize($field, '_', false))->add_rule('trim');
			}
		}
		
		if (array_key_exists('email', $input)) {
			$validator->add('email', 'Email')->add_rule('valid_email')->add_rule('trim');
		}
		
		return $validator;
	}
}
