<?php

/**
 * Customer model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Customer extends Model
{
	protected static $_properties = array(
		'id',
		'seller_id',
		'balance',
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
	
	protected static $_many_many = array(
		'contacts' => array(
			'key_from'         => 'id',
			'key_through_from' => 'customer_id',
			'table_through'    => 'customer_contacts',
			'key_through_to'   => 'contact_id',
			'model_to'         => 'Model_Contact',
			'key_to'           => 'id',
			'conditions'       => array(
				'where' => array('status' => 'active'),
			),
		),
	);
	
	protected static $_has_many = array(
		'products' => array(
			'model_to'   => 'Model_Customer_Product_Option',
			'conditions' => array(
				'where' => array('status' => 'active'),
			),
		),
	);
	
	/**
	 * Returns the customer action link.
	 *
	 * @param string $action The action to link to.
	 *
	 * @return string
	 */
	public function link($action = '')
	{
		$uri = 'customers/' . $this->id;
		if ($action) {
			$uri .= '/' . $action;
		}
		
		return \Uri::create($uri);
	}
	
	/**
	 * Primary contact helper function.
	 *
	 * @param string|array $properties One or more contact properties to return.
	 *
	 * @return string
	 */
	public function contact($properties = null)
	{
		$contact = Service_Contact::primary($this);
		if (!$contact) {
			return false;
		}
		
		if ($properties) {
			$data = array();
			
			$properties = (array) $properties;
			foreach ($properties as $property) {
				$data[] = $contact->$property;
			}
			
			return implode(' ', $data);
		}
		
		return $contact;
	}
	
	/**
	 * Name helper function.
	 *
	 * @return string
	 */
	public function name()
	{
		return $this->contact(array('first_name', 'last_name'));
	}
	
	/**
	 * Email address helper function.
	 *
	 * @return string
	 */
	public function email()
	{
		return $this->contact('email');
	}
}
