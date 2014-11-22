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
	
	/**
	 * Returns the product meta action link.
	 *
	 * @param string $action The action to link to.
	 *
	 * @return string
	 */
	public function link($action = '')
	{
		$uri = 'products/' . $this->product_id . '/metas/' . $this->id;
		if ($action) {
			$uri .= '/' . $action;
		}
		
		return Uri::create($uri);
	}
	
	/**
	 * Gets a property or relation.
	 *
	 * @param string $property The property or relation to fetch.
	 * 
	 * @return mixed
	 */
	public function & __get($property)
	{
		$value = parent::__get($property);
		if ($property == 'options') {
			// Sort options alphabetically by option value property.
			uasort($value, function($a, $b) {
				return strcmp($a->value, $b->value);
			});
		}
		
		return $value;
	}
}
