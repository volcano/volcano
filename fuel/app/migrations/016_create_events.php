<?php

namespace Fuel\Migrations;

/**
 * Events migration.
 */
class Create_Events
{
	public function up()
	{
		\DBUtil::create_table('events', array(
			'id'   => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'varchar', 'constraint' => 255),
		), array('id'));
		
		\DBUtil::create_index('events', 'name', 'name', 'unique');
	}
	
	public function down()
	{
		\DBUtil::drop_table('events');
	}
}
