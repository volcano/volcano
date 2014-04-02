<?php

namespace Fuel\Migrations;

/**
 * Seller gateways migration.
 */
class Create_Seller_Gateways
{
	public function up()
	{
		\DBUtil::create_table('seller_gateways', array(
			'id'         => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'seller_id'  => array('type' => 'int', 'constraint' => 11),
			'gateway_id' => array('type' => 'int', 'constraint' => 11),
		), array('id'));
		
		\DBUtil::create_index('seller_gateways', 'seller_id', 'seller_id');
		\DBUtil::create_index('seller_gateways', 'gateway_id', 'gateway_id');
	}
	
	public function down()
	{
		\DBUtil::drop_table('seller_gateways');
	}
}
