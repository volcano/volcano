<?php

/**
 * Customer order model.
 *
 * @author Keithia Stegmann <kstegmann@static.com>
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Customer_Order extends Model
{
	protected static $_properties = array(
		'id',
		'customer_id',
		'transaction_id',
		'status' => array('default' => 'pending'),
		'created_at',
		'updated_at',
	);
	
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
			'overwrite' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
		),
	);
	
	protected static $_belongs_to = array(
		'customer',
		'transaction' => array(
			'key_from' => 'transaction_id',
			'model_to' => 'Model_Customer_Transaction',
			'key_to'   => 'id',
		),
	);
	
	protected static $_has_many = array(
		'products' => array(
			'model_to' => 'Model_Customer_Product_Option',
		),
	);
}
