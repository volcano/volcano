<?php

namespace Fuel\Migrations;

/**
 * Api Keys migration.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Create_Api_Keys
{
	public function up()
	{
		\DBUtil::create_table('api_keys', array(
			'id'         => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'seller_id'  => array('type' => 'int', 'constraint' => 11),
			'key'        => array('type' => 'varchar', 'constraint' => 255),
			'status'     => array('type' => 'varchar', 'constraint' => 50),
			'created_at' => array('type' => 'datetime'),
			'updated_at' => array('type' => 'datetime'),
		), array('id'));
	}
	
	public function down()
	{
		\DBUtil::drop_table('api_keys');
	}
}
