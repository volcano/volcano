<?php

$nav = array(
	array(
		'href'       => 'settings/api/create',
		'value'      => 'Add API Key',
		'attributes' => array('class' => 'btn'),
		'icon'       => 'icon-plus',
	),
);

echo View_Helper::nav($nav, array('class' => 'nav-pills pull-right'));
