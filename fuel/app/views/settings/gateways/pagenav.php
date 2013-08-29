<?php

$nav = array(
	array(
		'href'       => 'settings/gateways/create',
		'value'      => 'Add Gateway',
		'attributes' => array('class' => 'btn'),
		'icon'       => 'icon-plus',
	),
);

echo View_Helper::nav($nav, array('class' => 'nav-pills pull-right'));
