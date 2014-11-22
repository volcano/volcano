<?php

namespace Fuel\Migrations;

/**
 * Modify contacts migration.
 */
class Modify_Contacts
{
	public function up()
	{
		\DBUtil::modify_fields('contacts', array(
			'first_name' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
			'last_name'  => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
		));
	}
	
	public function down()
	{
		\DBUtil::modify_fields('contacts', array(
			'first_name' => array('type' => 'varchar', 'constraint' => 255),
			'last_name'  => array('type' => 'varchar', 'constraint' => 255),
		));
	}
}
