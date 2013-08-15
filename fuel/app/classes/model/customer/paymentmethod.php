<?php

/**
 * Customer payment method model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Customer_Paymentmethod extends Model
{
	protected static $_properties = array(
		'id',
		'customer_id',
		'contact_id',
		'gateway_id',
		'external_id',
		'provider',
		'account',
		'primary',
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
		'customer',
		'contact',
		'gateway',
	);
	
	/**
	 * Builds an array of api-safe model data.
	 *
	 * @return array
	 */
	public function to_api_array()
	{
		return array(
			'id'          => $this->id,
			'customer_id' => $this->customer_id,
			'gateway_id'  => $this->gateway_id,
			'account'     => array(
				'provider' => $this->provider,
				'number'   => $this->account,
			),
			'contact'     => $this->contact,
			'primary'     => $this->primary,
			'status'      => $this->status,
			'created_at'  => $this->created_at,
			'updated_at'  => $this->updated_at,
		);
	}
	
	/**
	 * Returns the payment method action link.
	 *
	 * @param string $action The action to link to.
	 *
	 * @return string
	 */
	public function link($action = '')
	{
		$uri = 'customers/' . $this->customer->id . '/paymentmethods/' . $this->id;
		if ($action) {
			$uri .= '/' . $action;
		}
		
		return Uri::create($uri);
	}
	
	/**
	 * Returns whether this is a primary payment method.
	 *
	 * @return bool
	 */
	public function primary()
	{
		if (!$this->active()) {
			return false;
		}
		
		return (bool) $this->primary;
	}
	
	/**
	 * Type helper function.
	 *
	 * @return string
	 */
	public function type()
	{
		return Inflector::humanize(Inflector::words_to_upper($this->gateway->type));
	}
	
	/**
	 * Account details helper function.
	 *
	 * @return string
	 */
	public function account()
	{
		return $this->provider . ' ' . $this->account;
	}
}
