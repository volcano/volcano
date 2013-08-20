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
		'href'  => 'settings/api',
		'value' => 'API Keys',
	),
);

echo View_Helper::nav($nav);
