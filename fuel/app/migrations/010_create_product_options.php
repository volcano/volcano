<?php

namespace Fuel\Migrations;

/**
 * Product options migration.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Create_Product_Options
{
	public function up()
	{
		\DBUtil::create_table('product_options', array(
			'id'         => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'product_id' => array('type' => 'int', 'constraint' => 11),
			'name'       => array('type' => 'varchar', 'constraint' => 255),
			'status'     => array('type' => 'varchar', 'constraint' => 50),
			'created_at' => array('type' => 'datetime'),
			'updated_at' => array('type' => 'datetime'),
		), array('id'));
		
		\DBUtil::create_index('product_options', 'product_id', 'product_id');
	}
	
	public function down()
	{
		\DBUtil::drop_table('product_options');
	}
}
