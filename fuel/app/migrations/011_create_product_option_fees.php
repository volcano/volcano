<?php

namespace Fuel\Migrations;

/**
 * Product option fees migration.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Create_Product_Option_Fees
{
	public function up()
	{
		\DBUtil::create_table('product_option_fees', array(
			'id'                => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'product_option_id' => array('type' => 'int', 'constraint' => 11),
			'interval'          => array('type' => 'int', 'constraint' => 2),
			'interval_unit'     => array('type' => 'varchar', 'constraint' => 25),
			'interval_price'    => array('type' => 'decimal', 'constraint' => '10,2'),
			'status'            => array('type' => 'varchar', 'constraint' => 50),
			'created_at'        => array('type' => 'datetime'),
			'updated_at'        => array('type' => 'datetime'),
		), array('id'));
		
		\DBUtil::create_index('product_option_fees', 'product_option_id', 'product_option_id');
	}
	
	public function down()
	{
		\DBUtil::drop_table('product_option_fees');
	}
}
