<?php

namespace Fuel\Migrations;

/**
 * Contacts migration.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Create_Contacts
{
	public function up()
	{
		\DBUtil::create_table('contacts', array(
			'id'           => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'first_name'   => array('type' => 'varchar', 'constraint' => 255),
			'last_name'    => array('type' => 'varchar', 'constraint' => 255),
			'company_name' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
			'address'      => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
			'address2'     => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
			'city'         => array('type' => 'varchar', 'constraint' => 50, 'null' => true),
			'state'        => array('type' => 'varchar', 'constraint' => 50, 'null' => true),
			'zip'          => array('type' => 'varchar', 'constraint' => 20, 'null' => true),
			'country'      => array('type' => 'varchar', 'constraint' => 2, 'null' => true),
			'email'        => array('type' => 'varchar', 'constraint' => 50, 'null' => true),
			'phone'        => array('type' => 'varchar', 'constraint' => 20, 'null' => true),
			'fax'          => array('type' => 'varchar', 'constraint' => 20, 'null' => true),
			'created_at'   => array('type' => 'datetime'),
			'updated_at'   => array('type' => 'datetime'),
		), array('id'));
	}
	
	public function down()
	{
		\DBUtil::drop_table('contacts');
	}
}
