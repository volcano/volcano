<?php

namespace Fuel\Migrations;

/**
 * Customers migration.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Create_Customers
{
	public function up()
	{
		\DBUtil::create_table('customers', array(
			'id'         => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'seller_id'  => array('type' => 'int', 'constraint' => 11),
			'balance'    => array('type' => 'decimal', 'constraint' => '10,2'),
			'status'     => array('type' => 'varchar', 'constraint' => 50),
			'created_at' => array('type' => 'datetime'),
			'updated_at' => array('type' => 'datetime'),
		), array('id'));
	}
	
	public function down()
	{
		\DBUtil::drop_table('customers');
	}
}
