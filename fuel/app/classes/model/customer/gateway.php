<?php

/**
 * Customer gateway model.
 */
class Model_Customer_Gateway extends Model
{
	protected static $_properties = array(
		'id',
		'customer_id',
		'gateway_id',
		'external_id',
	);
	
	protected static $_belongs_to = array(
		'customer',
		'gateway',
	);
}
