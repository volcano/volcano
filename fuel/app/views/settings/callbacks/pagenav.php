<?php

$nav = array(
	array(
		'href'       => 'settings/callbacks/create',
		'value'      => 'Add Event Callback',
		'attributes' => array('class' => 'btn'),
		'icon'       => 'icon-plus',
	),
);

echo View_Helper::nav($nav, array('class' => 'nav-pills pull-right'));
