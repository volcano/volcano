<?php

/**
 * Validation seller callback class.
 */
class Validation_Seller_Callback
{
	/**
	 * Creates a new validation instance for seller callback create.
	 *
	 * @return Validation
	 */
	public static function create()
	{
		$validator = Validation::forge('callback');
		
		$validator->add('event', 'Event Name')->add_rule('trim')->add_rule('required')->add_rule(array('invalid_event_name' => function ($event_name) {
			$event = Service_Event::find_one(array('name' => $event_name));
			if (!$event) {
				return false;
			}
			
			return true;
		}));
		
		$validator->add('url', 'Callback URL')->add_rule('trim')->add_rule('valid_url')->add_rule('required');
		
		return $validator;
	}
	
	/**
	 * Creates a new validation instance for seller callback update.
	 *
	 * @return Validation
	 */
	public static function update()
	{
		$validator = Validation::forge('callback');
		
		$input = Input::param();
		
		if (array_key_exists('event', $input)) {
			$validator->add('event', 'Event Name')->add_rule('trim')->add_rule('required')->add_rule(array('invalid_event_name' => function ($event_name) {
				$event = Service_Event::find_one(array('name' => $event_name));
				if (!$event) {
					return false;
				}
				
				return true;
			}));
		}
		
		if (array_key_exists('url', $input)) {
			$validator->add('url', 'Callback URL')->add_rule('trim')->add_rule('valid_url')->add_rule('required');
		}
		
		return $validator;
	}
}
