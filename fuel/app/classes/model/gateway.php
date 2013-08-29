<?php

/**
 * Gateway model.
 *
 * @author Keithia Stegmann <kstegmann@static.com>
 */
class Model_Gateway extends Model
{
	protected static $_properties = array(
		'id',
		'type',
		'processor',
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
	
	protected static $_has_many = array(
		'meta' => array(
			'model_to' => 'Model_Gateway_Meta',
		),
	);
	
	protected static $_many_many = array(
		'sellers' => array(
			'key_from'         => 'id',
			'key_through_from' => 'gateway_id',
			'table_through'    => 'seller_gateways',
			'key_through_to'   => 'seller_id',
			'model_to'         => 'Model_Seller',
			'key_to'           => 'id',
			'conditions'       => array(
				'where' => array('status' => 'active'),
			),
		),
	);
	
	/**
	* Returns meta data for this gateway instance.
	*
	* @param string $name The meta name to get.
	*
	* @return array|mixed
	*/
	public function meta($name = null)
	{
		if (!$name) {
			return Model_Gateway_Meta::query()
				->where('gateway_id', $this->id)
				->get();
		} elseif (is_array($name)) {
			$meta_array = array();
			
			$metas = Model_Gateway_Meta::query()
				->where('gateway_id', $this->id)
				->where('name', 'in', $name)
				->get();
			
			foreach ($metas as $meta) {
				$meta_array[$meta->name] = $meta;
			}
			
			return $meta_array;
		}
		
		return Model_Gateway_Meta::find_by_gateway_id_and_name($this->id, $name);
	}
	
	/**
	 * Returns the gateway action link.
	 *
	 * @param string $action The action to link to.
	 *
	 * @return string
	 */
	public function link($action = '')
	{
		$uri = 'settings/gateways/' . $this->id;
		if ($action) {
			$uri .= '/' . $action;
		}
		
		return Uri::create($uri);
	}
	
	/**
	 * Determines whether the gateway is a credit card processor.
	 *
	 * @return bool
	 */
	public function processes_credit_cards()
	{
		if ($this->type != 'credit_card') {
			return false;
		}
		
		return true;
	}
}
