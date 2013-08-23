<?php

/**
 * Statistic task model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Statistic_Task extends Model
{
	protected static $_properties = array(
		'id',
		'type',
		'message',
		'status' => array('default' => 'running'),
		'created_at',
		'updated_at',
	);
	
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events'          => array('before_insert'),
			'mysql_timestamp' => true,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events'          => array('before_save'),
			'mysql_timestamp' => true,
		),
	);
}
