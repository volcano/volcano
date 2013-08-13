<?php

/**
 * Customer product options model.
 *
 * @author Keithia Stegmann <kstegmann@static.com>
 */
class Model_Customer_Product_Option extends Model
{
	protected static $_properties = array(
		'id',
		'customer_id',
		'product_option_id',
		'name',
		'status' => array('default' => 'pending'),
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
		'option' => array(
			'model_to' => 'Model_Product_Option',
		),
	);
	
	/**
	 * Returns the customer product option action link.
	 *
	 * @param string $action The action to link to.
	 *
	 * @return string
	 */
	public function link($action = '')
	{
		$uri = 'customers/' . $this->customer->id . '/products/' . $this->id;
		if ($action) {
			$uri .= '/' . $action;
		}
		
		return Uri::create($uri);
	}
	
	/**
	 * Returns whether this customer product option is active.
	 *
	 * @return bool
	 */
	public function active()
	{
		return $this->status == 'active';
	}
	
	/**
	 * Returns whether this customer product option is canceled.
	 *
	 * @return bool
	 */
	public function canceled()
	{
		return $this->status == 'canceled';
	}
}
