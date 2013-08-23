<?php

$nav = array(
	array(
		'href'    => 'statistics/customers/activity',
		'value'   => 'Activity',
		'aliases' => array('statistics'),
	),
	array(
		'href'  => 'statistics/customers/totals',
		'value' => 'Totals',
	),
	array(
		'href'  => 'statistics/customers/conversion',
		'value' => 'Conversion',
	),
);

echo View_Helper::nav($nav, array('class' => 'nav-pills pull-right'));
