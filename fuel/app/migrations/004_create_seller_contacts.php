<?php

namespace Fuel\Migrations;

/**
 * Seller contacts migration.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Create_Seller_Contacts
{
	public function up()
	{
		\DBUtil::create_table('seller_contacts', array(
			'id'         => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
			'seller_id'  => array('type' => 'int', 'constraint' => 11),
			'contact_id' => array('type' => 'int', 'constraint' => 11),
		), array('id'));
		
		\DBUtil::create_index('seller_contacts', 'seller_id', 'seller_id');
	}
	
	public function down()
	{
		\DBUtil::drop_table('seller_contacts');
	}
}
