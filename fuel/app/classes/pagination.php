<?php

/**
 * Base pagination class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Pagination extends \Fuel\Core\Pagination
{
	/**
	 * Forges a new pagination instance.
	 *
	 * @return Pagination
	 */
	public static function forge($name = 'default', $config = array())
	{
		$config = array_merge(array(
			'per_page'     => 20,
			'uri_segment'  => 'page',
			'current_page' => Input::get('page', 1),
		), $config);
		
		return parent::forge($name, $config);
	}
}
