<?php

/**
 * Customer transaction model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Customer_Transaction extends Model
{
	protected static $_properties = array(
		'id',
		'customer_id',
		'gateway_id',
		'external_id',
		'type',
		'provider',
		'account',
		'amount',
		'status' => array('default' => 'paid'),
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
			'account'     => array(
				'type'     => $this->type,
				'provider' => $this->provider,
				'number'   => $this->account,
			),
			'amount'      => $this->amount,
			'status'      => $this->status,
			'created_at'  => $this->created_at,
			'updated_at'  => $this->updated_at,
		);
	}
	
	/**
	 * Payment method details helper function.
	 *
	 * @return string
	 */
	public function paymentmethod()
	{
		$type = Inflector::humanize(Inflector::words_to_upper($this->type));
		
		return $type . ' ' . $this->provider . ' ' . $this->account;
	}
}
