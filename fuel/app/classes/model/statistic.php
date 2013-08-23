<?php

/**
 * Statistic model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Statistic extends Model
{
	protected static $_properties = array(
		'id',
		'seller_id',
		'type',
		'name',
		'value',
		'date',
	);
	
	protected static $_belongs_to = array(
		'seller',
	);
}
