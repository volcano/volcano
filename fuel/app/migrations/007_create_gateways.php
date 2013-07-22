<?php

namespace Fuel\Migrations;

/**
 * Gateways migration.
 *
 * @author Keithia Stegmann <kstegmann@static.com>
 */
class Create_Gateways
{
	public function up()
	{
		\DBUtil::create_table('gateways', array(
			'id'         => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'type'       => array('type' => 'varchar', 'constraint' => 20),
			'processor'  => array('type' => 'varchar', 'constraint' => 50),
			'status'     => array('constraint' => 50, 'type' => 'varchar'),
			'created_at' => array('type' => 'datetime'),
			'updated_at' => array('type' => 'datetime'),
		), array('id'));
	}
	
	public function down()
	{
		\DBUtil::drop_table('gateways');
	}
}
