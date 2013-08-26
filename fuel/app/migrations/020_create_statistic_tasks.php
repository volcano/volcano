<?php

namespace Fuel\Migrations;

/**
 * statistic_tasks migration.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Create_Statistic_Tasks
{
	public function up()
	{
		\DBUtil::create_table('statistic_tasks', array(
			'id'         => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'type'       => array('type' => 'varchar', 'constraint' => 255),
			'message'    => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
			'status'     => array('type' => 'varchar', 'constraint' => 50),
			'created_at' => array('type' => 'datetime'),
			'updated_at' => array('type' => 'datetime'),
		), array('id'));
		
		\DBUtil::create_index('statistic_tasks', 'type', 'type');
		\DBUtil::create_index('statistic_tasks', array('type', 'status'), 'type_status');
	}
	
	public function down()
	{
		\DBUtil::drop_table('statistic_tasks');
	}
}
