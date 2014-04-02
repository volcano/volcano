<?php

namespace Fuel\Migrations;

/**
 * Gateway metas migration.
 */
class Create_Gateway_Metas
{
	public function up()
	{
		\DBUtil::create_table('gateway_metas', array(
			'id'         => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'gateway_id' => array('type' => 'int', 'constraint' => 11),
			'name'       => array('type' => 'varchar', 'constraint' => 255),
			'value'      => array('type' => 'text'),
			'created_at' => array('type' => 'datetime'),
			'updated_at' => array('type' => 'datetime'),
		), array('id'));
		
		\DBUtil::create_index('gateway_metas', 'gateway_id', 'gateway_id');
		\DBUtil::create_index('gateway_metas', array('gateway_id', 'name'), 'name', 'unique');
	}
	
	public function down()
	{
		\DBUtil::drop_table('gateway_metas');
	}
}
