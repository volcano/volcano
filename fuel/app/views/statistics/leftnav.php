<?php

$nav = array(
	array(
		'href'    => 'statistics/customers',
		'value'   => 'Customers',
		'aliases' => array('statistics', 'statistics/customers/*'),
	),
);

echo View_Helper::nav($nav);
