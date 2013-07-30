<?php

/**
 * Customer payment method model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Customer_Paymentmethod extends Model
{
	protected static $_properties = array(
		'id',
		'customer_id',
		'contact_id',
		'gateway_id',
		'external_id',
		'default',
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
		'customer',
		'contact',
		'gateway',
	);
}
