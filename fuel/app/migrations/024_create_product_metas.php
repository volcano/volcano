<?php

namespace Fuel\Migrations;

/**
 * Product metas migration.
 */
class Create_Product_Metas
{
	public function up()
	{
		\DBUtil::create_table('product_metas', array(
			'id'         => array('type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true),
			'product_id' => array('type' => 'int', 'constraint' => 11, 'unsigned' => true),
			'name'       => array('type' => 'varchar', 'constraint' => 255),
			'created_at' => array('type' => 'datetime'),
			'updated_at' => array('type' => 'datetime'),
		), array('id'));
		
		\DBUtil::create_index('product_metas', 'product_id', 'product_id');
	}
	
	public function down()
	{
		\DBUtil::drop_table('product_metas');
	}
}
