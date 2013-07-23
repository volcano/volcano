<?php

/**
 * Gateway Meta model.
 *
 * @author Keithia Stegmann <kstegmann@static.com>
 */
class Model_Gateway_Meta extends Model
{
	protected static $_properties = array(
		'id',
		'gateway_id',
		'name',
		'value',
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

	protected static $_belongs_to = array(
		'gateway',
	);

	/**
	 * Generates a new meta instance.
	 *
	 * @param string $name  The name of the meta.
	 * @param string $value The value of the meta.
	 *
	 * @return Model_Client_Meta
	 */
	public static function name($name, $value)
	{
		return self::forge(array(
			'name'  => $name,
			'value' => $value,
		));
	}
}
