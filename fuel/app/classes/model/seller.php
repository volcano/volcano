<?php

/**
 * Seller model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Seller extends Model
{
	protected static $_properties = array(
		'id',
		'contact_id',
		'name',
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
	
	protected static $_belongs_to = array(
		'contact' => array(
			'model_to' => 'Model_Contact',
		),
	);
}
