<?php

/**
 * Product meta model.
 */
class Model_Product_Meta extends Model
{
	protected static $_properties = array(
		'id',
		'product_id',
		'name',
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
		'product',
	);
	
	protected static $_has_many = array(
		'options' => array(
			'model_to'   => 'Model_Product_Meta_Option',
		),
	);
}
