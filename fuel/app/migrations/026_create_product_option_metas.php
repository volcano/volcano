<?php

namespace Fuel\Migrations;

/**
 * Product option metas migration.
 */
class Create_Product_Option_Metas
{
	public function up()
	{
		\DBUtil::create_table('product_option_metas', array(
			'id'                     => array('type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true),
			'product_option_id'      => array('type' => 'int', 'constraint' => 11, 'unsigned' => true),
			'product_meta_option_id' => array('type' => 'int', 'constraint' => 11, 'unsigned' => true),
		), array('id'));
		
		\DBUtil::create_index('product_option_metas', 'product_option_id', 'product_option_id');
	}

	public function down()
	{
		\DBUtil::drop_table('product_option_metas');
	}
}