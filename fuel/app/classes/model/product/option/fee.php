<?php

/**
 * Product option fee model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Product_Option_Fee extends Model
{
	protected static $_properties = array(
		'id',
		'product_option_id',
		'interval',
		'interval_unit',
		'interval_price',
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
		'option' => array(
			'model_to' => 'Model_Product_Option',
		),
	);
}
