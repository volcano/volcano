<?php

namespace Fuel\Migrations;

class Auth_Fix_Jointables
{

	function up()
	{
		// get the driver used
		\Config::load('auth', true);

		$drivers = \Config::get('auth.driver', array());
		is_array($drivers) or $drivers = array($drivers);

		if (in_array('Ormauth', $drivers))
		{
			// get the tablename
			\Config::load('ormauth', true);
			$basetable = \Config::get('ormauth.table_name', 'users');

			// make sure the configured DB is used
			\DBUtil::set_connection(\Config::get('simpleauth.db_connection', null));

			\DBUtil::drop_index($basetable.'_user_permissions', 'primary');
			\DBUtil::add_fields($basetable.'_user_permissions', array(
				'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true, 'primary_key' => true, 'first' => true),
			));

			\DBUtil::drop_index($basetable.'_group_permissions', 'primary');
			\DBUtil::add_fields($basetable.'_group_permissions', array(
				'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true, 'primary_key' => true, 'first' => true),
			));

			\DBUtil::drop_index($basetable.'_role_permissions', 'primary');
			\DBUtil::add_fields($basetable.'_role_permissions', array(
				'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true, 'primary_key' => true, 'first' => true),
			));
		}

		// reset any DBUtil connection set
		\DBUtil::set_connection(null);
	}

	function down()
	{
		// get the driver used
		\Config::load('auth', true);

		$drivers = \Config::get('auth.driver', array());
		is_array($drivers) or $drivers = array($drivers);

		if (in_array('Ormauth', $drivers))
		{
			// get the tablename
			\Config::load('ormauth', true);
			$basetable = \Config::get('ormauth.table_name', 'users');

			// make sure the configured DB is used
			\DBUtil::set_connection(\Config::get('ormauth.db_connection', null));

			\DBUtil::drop_fields($basetable.'_user_permissions', array(
				'id',
			));
			\DBUtil::create_index($basetable.'_user_permissions', array('user_id', 'perms_id'), '', 'PRIMARY');


			\DBUtil::drop_fields($basetable.'_group_permissions', array(
				'id',
			));
			\DBUtil::create_index($basetable.'_group_permissions', array('group_id', 'perms_id'), '', 'PRIMARY');

			\DBUtil::drop_fields($basetable.'_role_permissions', array(
				'id',
			));
			\DBUtil::create_index($basetable.'_role_permissions', array('role_id', 'perms_id'), '', 'PRIMARY');
		}

		// reset any DBUtil connection set
		\DBUtil::set_connection(null);
	}
}
