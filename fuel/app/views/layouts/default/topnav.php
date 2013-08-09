<?php

$topnav = array(
	array(
		'href'    => '/',
		'value'   => 'Dashboard',
		'icon'    => 'icon-home',
		'aliases' => array(''),
	),
	array(
		'href'    => 'customers',
		'value'   => 'Customers',
		'icon'    => 'icon-user',
		'aliases' => array('customers/*'),
	),
);

echo View_Helper::nav($topnav);
