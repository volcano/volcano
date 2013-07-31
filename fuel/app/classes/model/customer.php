<?php

/**
 * Customer model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Customer extends Model
{
	protected static $_properties = array(
		'id',
		'seller_id',
		'balance',
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
		'seller',
	);
	
	protected static $_many_many = array(
		'contacts' => array(
			'key_from'         => 'id',
			'key_through_from' => 'customer_id',
			'table_through'    => 'customer_contacts',
			'key_through_to'   => 'contact_id',
			'model_to'         => 'Model_Contact',
			'key_to'           => 'id',
			'conditions'       => array(
				'where' => array('status' => 'active'),
			),
		),
	);
}
