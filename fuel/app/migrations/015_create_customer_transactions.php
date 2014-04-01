<?php

namespace Fuel\Migrations;

/**
 * Customer transactions migration.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Create_Customer_Transactions
{
	public function up()
	{
		\DBUtil::create_table('customer_transactions', array(
			'id'          => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'customer_id' => array('type' => 'int', 'constraint' => 11),
			'gateway_id'  => array('type' => 'int', 'constraint' => 11),
			'external_id' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
			'type'        => array('type' => 'varchar', 'constraint' => 50),
			'provider'    => array('type' => 'varchar', 'constraint' => 50),
			'account'     => array('type' => 'varchar', 'constraint' => 50),
			'amount'      => array('type' => 'decimal', 'constraint' => '10,2'),
			'status'      => array('type' => 'varchar', 'constraint' => 50),
			'created_at'  => array('type' => 'datetime'),
			'updated_at'  => array('type' => 'datetime'),
		), array('id'));
		
		\DBUtil::create_index('customer_transactions', 'customer_id', 'customer_id');
		\DBUtil::create_index('customer_transactions', array('customer_id', 'status'), 'customer_status');
	}
	
	public function down()
	{
		\DBUtil::drop_table('customer_transactions');
	}
}
