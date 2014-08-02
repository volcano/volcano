<?php

$nav = array(
	array(
		'href'       => 'settings/contacts/create',
		'value'      => 'Add Contact',
		'attributes' => array('class' => 'btn'),
		'icon'       => 'icon-plus',
	),
);

echo View_Helper::nav($nav, array('class' => 'nav-pills pull-right'));
