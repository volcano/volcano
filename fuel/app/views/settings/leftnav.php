<?php

$nav = array(
	array(
		'href'  => 'settings',
		'value' => 'General',
	),
	array(
		'href'  => 'settings/contacts',
		'value' => 'Contacts',
	),
	array(
		'href'  => 'settings/gateways',
		'value' => 'Gateways',
	),
	array(
		'href'  => 'settings/api',
		'value' => 'API Keys',
	),
	array(
		'href'  => 'settings/callbacks',
		'value' => 'Event Callbacks',
	),
);

echo View_Helper::nav($nav);
