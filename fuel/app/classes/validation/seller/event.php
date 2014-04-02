<?php

/**
 * Validation seller event class.
 */
class Validation_Seller_Event
{
	/**
	 * Creates a new validation instance for seller event create.
	 *
	 * @return Validation
	 */
	public static function create()
	{
		$validator = Validation::forge('seller_event');
		
		$validator->add('event', 'Event Name')->add_rule('trim')->add_rule('required')->add_rule(array('invalid_event_name' => function ($event_name) {
			$event = Service_Event::find_one(array('name' => $event_name));
			if (!$event) {
				return false;
			}
			
			return true;
		}));
		
		$validator->add('callback', 'Callback URL')->add_rule('trim')->add_rule('valid_url')->add_rule('required');
		
		return $validator;
	}
	
	/**
	 * Creates a new validation instance for seller event update.
	 *
	 * @return Validation
	 */
	public static function update()
	{
		$validator = Validation::forge('seller_event');
		
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
		
		if (array_key_exists('callback', $input)) {
			$validator->add('callback', 'Callback URL')->add_rule('trim')->add_rule('valid_url')->add_rule('required');
		}
		
		return $validator;
	}
}
