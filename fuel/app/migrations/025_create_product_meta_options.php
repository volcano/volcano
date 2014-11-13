<?php

namespace Fuel\Migrations;

/**
 * Product meta options migration.
 */
class Create_Product_Meta_Options
{
	public function up()
	{
		\DBUtil::create_table('product_meta_options', array(
			'id'              => array('type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true),
			'product_meta_id' => array('type' => 'int', 'constraint' => 11, 'unsigned' => true),
			'value'           => array('type' => 'text'),
			'created_at'      => array('type' => 'datetime'),
			'updated_at'      => array('type' => 'datetime'),
		), array('id'));
		
		\DBUtil::create_index('product_meta_options', 'product_meta_id', 'product_meta_id');
	}
	
	public function down()
	{
		\DBUtil::drop_table('product_meta_options');
	}
}
