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
		'name',
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
	
	/**
	 * Returns the product option fee action link.
	 *
	 * @param string $action The action to link to.
	 *
	 * @return string
	 */
	public function link($action = '')
	{
		$uri = 'products/' . $this->option->product->id . '/options/' . $this->option->id . '/fees/' . $this->id;
		if ($action) {
			$uri .= '/' . $action;
		}
		
		return Uri::create($uri);
	}
	
	/**
	 * Returns whether this fee is recurring.
	 *
	 * @return bool
	 */
	public function recurring()
	{
		return $this->interval_unit != 'nonrecurring';
	}
}
