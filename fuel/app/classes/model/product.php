<?php

/**
 * Product model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Product extends Model
{
	protected static $_properties = array(
		'id',
		'seller_id',
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
		'seller',
	);
	
	protected static $_has_many = array(
		'options' => array(
			'model_to'   => 'Model_Product_Option',
			'conditions' => array(
				'where' => array('status' => 'active'),
			),
		),
	);
	
	/**
	 * Returns the product action link.
	 *
	 * @param string $action The action to link to.
	 *
	 * @return string
	 */
	public function link($action = '')
	{
		$uri = 'products/' . $this->id;
		if ($action) {
			$uri .= '/' . $action;
		}
		
		return Uri::create($uri);
	}
}
