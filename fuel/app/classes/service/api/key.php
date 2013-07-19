<?php

/**
 * Api Key service.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Service_Api_Key extends Service
{
	/**
	 * Query models based on optional filters passed in.
	 *
	 * @param array $options The optional options to use.
	 *
	 * @return Query
	 */
	protected static function query(array $options = array())
	{
		$options = array_merge(array(
			'status' => 'active',
		), $options);
		
		$api_keys = Model_Api_Key::query();
		
		if (!empty($options['key'])) {
			$api_keys->where('key', $options['key']);
		}
		
		if (!empty($options['status'])) {
			$api_keys->where('status', $options['status']);
		}
		
		if (!empty($options['limit'])) {
			$api_keys->limit($options['limit']);
		}
		
		return $api_keys;
	}
}
