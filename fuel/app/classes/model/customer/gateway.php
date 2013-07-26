<?php

/**
 * Customer gateway model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Customer_Gateway extends Model
{
	protected static $_properties = array(
		'id',
		'customer_id',
		'gateway_id',
		'external_id',
	);
}
