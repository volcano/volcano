<?php

namespace Fuel\Migrations;

/**
 * Sellers migration.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Create_Sellers
{
	public function up()
	{
		\DBUtil::create_table('sellers', array(
			'id'         => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'contact_id' => array('type' => 'int', 'constraint' => 11),
			'name'       => array('type' => 'varchar', 'constraint' => 255),
			'status'     => array('type' => 'varchar', 'constraint' => 50),
			'created_at' => array('type' => 'datetime'),
			'updated_at' => array('type' => 'datetime'),
		), array('id'));
	}
	
	public function down()
	{
		\DBUtil::drop_table('sellers');
	}
}
