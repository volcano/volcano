<?php

namespace Fuel\Migrations;

/**
 * Customer orders migration.
 */
class Rename_Seller_Events
{
	public function up()
	{
		\DBUtil::rename_table('seller_events', 'seller_callbacks');
		\DBUtil::modify_fields(
			'seller_callbacks',
			array('callback' => array('name' => 'url', 'type' => 'varchar', 'constraint' => 255))
		);
	}
	
	public function down()
	{
		\DBUtil::rename_table('seller_callbacks', 'seller_events');
		\DBUtil::modify_fields(
			'seller_events',
			array('url' => array('name' => 'callback', 'type' => 'varchar', 'constraint' => 255))
		);
	}
}
