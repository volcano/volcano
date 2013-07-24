<?php

namespace Fuel\Migrations;

/**
 * Products migration.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Create_Products
{
	public function up()
	{
		\DBUtil::create_table('products', array(
			'id'         => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'seller_id'  => array('type' => 'int', 'constraint' => 11),
			'name'       => array('type' => 'varchar', 'constraint' => 255),
			'status'     => array('type' => 'varchar', 'constraint' => 50),
			'created_at' => array('type' => 'datetime'),
			'updated_at' => array('type' => 'datetime'),
		), array('id'));
		
		\DBUtil::create_index('products', 'seller_id', 'seller_id');
	}
	
	public function down()
	{
		\DBUtil::drop_table('products');
	}
}
