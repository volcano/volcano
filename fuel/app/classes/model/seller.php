<?php

/**
 * Seller model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Seller extends Model
{
	protected static $_properties = array(
		'id',
		'name',
		'status' => array('default' => 'active'),
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
	
	protected static $_many_many = array(
		'contacts' => array(
			'key_from'         => 'id',
			'key_through_from' => 'seller_id',
			'table_through'    => 'seller_contacts',
			'key_through_to'   => 'contact_id',
			'model_to'         => 'Model_Contact',
			'key_to'           => 'id',
			'conditions'       => array(
				'where' => array('status' => 'active'),
			),
		),
		'gateways' => array(
			'key_from'         => 'id',
			'key_through_from' => 'seller_id',
			'table_through'    => 'seller_gateways',
			'key_through_to'   => 'gateway_id',
			'model_to'         => 'Model_Gateway',
			'key_to'           => 'id',
			'conditions'       => array(
				'where' => array('status' => 'active'),
			),
		),
	);
	
	/**
	 * Returns the seller action link.
	 *
	 * @param string $action The action to link to.
	 *
	 * @return string
	 */
	public function link($action = '')
	{
		$uri = 'settings/';
		if ($action) {
			if ($action == 'switch') {
				$uri .= $this->id . '/' . $action;
			} else {
				$uri .= $action;
			}
			
		}
		
		return Uri::create($uri);
	}
}
