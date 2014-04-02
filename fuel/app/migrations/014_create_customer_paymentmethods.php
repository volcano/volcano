<?php

namespace Fuel\Migrations;

/**
 * Customer payment methods migration.
 */
class Create_Customer_Paymentmethods
{
	public function up()
	{
		\DBUtil::create_table('customer_paymentmethods', array(
			'id'          => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'customer_id' => array('type' => 'int', 'constraint' => 11),
			'contact_id'  => array('type' => 'int', 'constraint' => 11),
			'gateway_id'  => array('type' => 'int', 'constraint' => 11),
			'external_id' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
			'provider'    => array('type' => 'varchar', 'constraint' => 50),
			'account'     => array('type' => 'varchar', 'constraint' => 50),
			'primary'     => array('type' => 'bool', 'null' => true),
			'status'      => array('type' => 'varchar', 'constraint' => 50),
			'created_at'  => array('type' => 'datetime'),
			'updated_at'  => array('type' => 'datetime'),
		), array('id'));
		
		\DBUtil::create_index('customer_paymentmethods', 'customer_id', 'customer_id');
		\DBUtil::create_index('customer_paymentmethods', array('customer_id', 'status'), 'customer_status');
	}
	
	public function down()
	{
		\DBUtil::drop_table('customer_paymentmethods');
	}
}
