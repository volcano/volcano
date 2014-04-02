<?php

namespace Fuel\Migrations;

/**
 * Customer gateways migration.
 */
class Create_Customer_Gateways
{
	public function up()
	{
		\DBUtil::create_table('customer_gateways', array(
			'id'          => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'customer_id' => array('type' => 'int', 'constraint' => 11),
			'gateway_id'  => array('type' => 'int', 'constraint' => 11),
			'external_id' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
		), array('id'));
		
		\DBUtil::create_index('customer_gateways', 'customer_id', 'customer_id');
		\DBUtil::create_index('customer_gateways', 'gateway_id', 'gateway_id');
		\DBUtil::create_index('customer_gateways', array('customer_id', 'gateway_id'), 'customer_gateway', 'unique');
	}
	
	public function down()
	{
		\DBUtil::drop_table('customer_gateways');
	}
}
