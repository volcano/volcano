<?php

namespace Fuel\Migrations;

/**
 * Statistics migration.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Create_Statistics
{
	public function up()
	{
		\DBUtil::create_table('statistics', array(
			'id'         => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'seller_id'  => array('type' => 'int', 'constraint' => 11),
			'type'       => array('type' => 'varchar', 'constraint' => 50),
			'name'       => array('type' => 'varchar', 'constraint' => 255),
			'value'      => array('type' => 'text'),
			'date'       => array('type' => 'date'),
		), array('id'));
		
		\DBUtil::create_index('statistics', 'seller_id', 'seller_id');
		\DBUtil::create_index('statistics', array('seller_id', 'type'), 'seller_type');
		\DBUtil::create_index('statistics', array('seller_id', 'type', 'name'), 'seller_type_name');
	}
	
	public function down()
	{
		\DBUtil::drop_table('statistics');
	}
}
