<?php

/**
 * Seller event model.
 */
class Model_Seller_Event extends Model
{
	protected static $_properties = array(
		'id',
		'seller_id',
		'event_id',
		'callback',
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
		'event',
	);
}
