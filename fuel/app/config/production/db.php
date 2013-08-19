<?php

$db_config = array();
$db_config_file = '/var/www/volcano.static.com/config/db.php';
if (file_exists($db_config_file)) {
	$tmp_db_config = include $db_config_file;
	if ($tmp_db_config && is_array($tmp_db_config)) {
		$db_config = $tmp_db_config;
	}
}

$host = Arr::get($db_config, 'default.connection.host');
$name = Arr::get($db_config, 'default.connection.name');
$user = Arr::get($db_config, 'default.connection.user');
$pass = Arr::get($db_config, 'default.connection.pass');

return array(
	'default' => array(
		'connection'  => array(
			'dsn'      => "mysql:host=$host;dbname=$name",
			'username' => $user,
			'password' => $pass,
		),
		'enable_cache' => true,
		'profiling'    => false,
	),
);
