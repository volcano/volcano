<?php

/**
 * Product option model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Product_Option extends Model
{
	protected static $_properties = array(
		'id',
		'product_id',
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
		'product',
	);
	
	protected static $_has_many = array(
		'fees' => array(
			'key_from'   => 'id',
			'model_to'   => 'Model_Product_Option_Fee',
			'key_to'     => 'product_option_id',
			'conditions' => array(
				'where' => array('status' => 'active'),
			),
		),
	);
	
	/**
	 * Returns the product option action link.
	 *
	 * @param string $action The action to link to.
	 *
	 * @return string
	 */
	public function link($action = '')
	{
		$uri = 'products/' . $this->product_id . '/options/' . $this->id;
		if ($action) {
			$uri .= '/' . $action;
		}
		
		return Uri::create($uri);
	}
	
	/**
	 * Adds up all of the product option's fee prices.
	 *
	 * @return float
	 */
	public function sum_fees()
	{
		$total = 0;
		
		$fees = $this->fees;
		foreach ($fees as $fee) {
			$total += $fee->interval_price;
		}
		
		return $total;
	}
}
