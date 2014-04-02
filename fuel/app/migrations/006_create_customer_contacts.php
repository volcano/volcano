<?php

namespace Fuel\Migrations;

/**
 * Customer contacts migration.
 */
class Create_Customer_Contacts
{
	public function up()
	{
		\DBUtil::create_table('customer_contacts', array(
			'id'          => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'customer_id' => array('type' => 'int', 'constraint' => 11),
			'contact_id'  => array('type' => 'int', 'constraint' => 11),
			'primary'     => array('type' => 'bool', 'null' => true),
		), array('id'));
		
		\DBUtil::create_index('customer_contacts', 'customer_id', 'customer_id');
	}
	
	public function down()
	{
		\DBUtil::drop_table('customer_contacts');
	}
}
