<?php

/**
 * Contact model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Contact extends Model
{
	protected static $_properties = array(
		'id',
		'first_name',
		'last_name',
		'company_name',
		'address',
		'address2',
		'city',
		'state',
		'zip',
		'country',
		'email',
		'phone',
		'fax',
		'status' => array('default' => 'active'),
		'created_at',
		'updated_at',
	);
	
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
		),
	);
	
	/**
	 * Returns the contact action link.
	 *
	 * @param string $action The base to link to.
	 * @param string $action The action to link to.
	 *
	 * @return string
	 */
	public function link($base = '', $action = '')
	{
		$uri = $base . '/contacts/' . $this->id;
		if ($action) {
			$uri .= '/' . $action;
		}
		
		return Uri::create($uri);
	}
	
	/**
	 * Name helper function.
	 *
	 * @return string
	 */
	public function name()
	{
		return $this->first_name . ' ' . $this->last_name;
	}
	
	/**
	 * Phone number helper function.
	 *
	 * @return string
	 */
	public function phone()
	{
		return Num::smart_format_phone($this->phone);
	}
	
	/**
	 * Country helper function.
	 *
	 * @return string
	 */
	public function country()
	{
		if (empty($this->country)) {
			return false;
		}
		
		Lang::load('countries', true);
		
		$countries = __('countries');
		
		return $countries[$this->country];
	}
}
