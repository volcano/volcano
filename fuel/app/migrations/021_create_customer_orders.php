<?php

namespace Fuel\Migrations;

/**
 * Customer orders migration.
 */
class Create_Customer_Orders
{
	public function up()
	{
		\DBUtil::create_table('customer_orders', array(
			'id'             => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'customer_id'    => array('type' => 'int', 'constraint' => 11),
			'transaction_id' => array('type' => 'int', 'constraint' => 11),
			'status'         => array('type' => 'varchar', 'constraint' => 50),
			'created_at'     => array('type' => 'datetime'),
			'updated_at'     => array('type' => 'datetime'),
		), array('id'));
		
		\DBUtil::create_index('customer_orders', 'customer_id', 'customer_id');
		\DBUtil::create_index('customer_orders', 'transaction_id', 'transaction_id');
	}
	
	public function down()
	{
		\DBUtil::drop_table('customer_orders');
	}
}
