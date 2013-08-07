<?php

namespace Fuel\Migrations;

/**
 * Seller events migration.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Create_Seller_Events
{
	public function up()
	{
		\DBUtil::create_table('seller_events', array(
			'id'         => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'seller_id'  => array('type' => 'int', 'constraint' => 11),
			'event_id'   => array('type' => 'int', 'constraint' => 11),
			'callback'   => array('type' => 'varchar', 'constraint' => 255),
			'status'     => array('type' => 'varchar', 'constraint' => 50),
			'created_at' => array('type' => 'datetime'),
			'updated_at' => array('type' => 'datetime'),
		), array('id'));
		
		\DBUtil::create_index('seller_events', array('seller_id', 'status'), 'seller_status');
		\DBUtil::create_index('seller_events', array('seller_id', 'event_id', 'status'), 'seller_event_status');
	}
	
	public function down()
	{
		\DBUtil::drop_table('seller_events');
	}
}
