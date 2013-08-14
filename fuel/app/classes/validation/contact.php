<?php

/**
 * Validation Contact class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Validation_Contact extends Validation
{
	/**
	 * Creates a new validation instance for contact create.
	 *
	 * @return Validation
	 */
	public static function create($type = 'customer')
	{
		$validator = Validation::forge('contact');
		
		$validator->add('first_name', 'First Name')->add_rule('trim')->add_rule('required');
		$validator->add('last_name', 'Last Name')->add_rule('trim')->add_rule('required');
		
		if ($type == 'seller' || $type == 'customer') {
			$validator->add('email', 'Email')->add_rule('trim')->add_rule('valid_email')->add_rule('required');
		} elseif ($type == 'paymentmethod') {
			$validator = self::add_address_fields($validator);
		}
		
		$validator = self::add_optional_fields($validator);
		
		return $validator;
	}
	
	/**
	 * Creates a new validation instance for contact update.
	 *
	 * @return Validation
	 */
	public static function update($type = 'customer')
	{
		$validator = Validation::forge('contact');
		
		$input = Input::param();
		
		if (array_key_exists('first_name', $input)) {
			$validator->add('first_name', 'First Name')->add_rule('trim')->add_rule('required');
		}
		
		if (array_key_exists('last_name', $input)) {
			$validator->add('last_name', 'Last Name')->add_rule('trim')->add_rule('required');
		}
		
		if ($type == 'seller' || $type == 'customer') {
			$validator->add('email', 'Email')->add_rule('trim')->add_rule('valid_email')->add_rule('required');
		} elseif ($type == 'paymentmethod') {
			$validator = self::add_address_fields($validator);
		}
		
		$validator = self::add_optional_fields($validator);
		
		return $validator;
	}
	
	/**
	 * Adds address fields to a Validation object.
	 *
	 * @param Validation $validator Validation object.
	 * 
	 * @return Validation
	 */
	protected static function add_address_fields(Validation $validator)
	{
		Lang::load('countries', true);
		$country_codes = array_keys($countries = __('countries'));
		
		$validator->add('address', 'Address')->add_rule('trim')->add_rule('required');
		$validator->add('address2', 'Address2')->add_rule('trim');
		$validator->add('city', 'City')->add_rule('trim')->add_rule('required');
		$validator->add('state', 'State')->add_rule('trim')->add_rule('required');
		$validator->add('zip', 'Zip')->add_rule('trim')->add_rule('required');
		$validator->add('country', 'Country')->add_rule('valid_value', $country_codes)->add_rule('required');
		
		return $validator;
	}
	
	/**
	 * Adds optional fields to a Validation object.
	 *
	 * @param Validation $validator Validation object.
	 * 
	 * @return Validation
	 */
	protected static function add_optional_fields(Validation $validator)
	{
		$input = Input::param();
		
		if (array_key_exists('company_name', $input)) {
			$validator->add('company_name', 'Company Name')->add_rule('trim');
		}
		
		if (array_key_exists('phone', $input)) {
			$validator->add('phone', 'Phone')->add_rule('trim')->add_rule('number');
		}
		
		if (array_key_exists('fax', $input)) {
			$validator->add('fax', 'Fax')->add_rule('trim')->add_rule('number');
		}
		
		return $validator;
	}
}
