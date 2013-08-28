<?php

namespace Fuel\Migrations;

/**
 * Customer product options migration.
 *
 * @author Keithia Stegmann <kstegmann@static.com>
 */
class Create_Customer_Product_Options
{
	public function up()
	{
		\DBUtil::create_table('customer_product_options', array(
			'id'                => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'customer_id'       => array('type' => 'int', 'constraint' => 11),
			'order_id'          => array('type' => 'int', 'constraint' => 11),
			'product_option_id' => array('type' => 'int', 'constraint' => 11),
			'name'              => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
			'status'            => array('type' => 'varchar', 'constraint' => 50),
			'created_at'        => array('type' => 'datetime'),
			'updated_at'        => array('type' => 'datetime'),
		), array('id'));
		
		\DBUtil::create_index('customer_product_options', 'customer_id', 'customer_id');
		\DBUtil::create_index('customer_product_options', 'product_option_id', 'product_option_id');
	}
	
	public function down()
	{
		\DBUtil::drop_table('customer_product_options');
	}
}
