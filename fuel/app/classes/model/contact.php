<?php

/**
 * Contact model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Contact extends \Orm\Model
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
}
