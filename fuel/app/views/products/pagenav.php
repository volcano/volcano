<?php

$nav = array(
	array(
		'href'       => 'products/create',
		'value'      => 'Create Product',
		'attributes' => array('class' => 'btn'),
		'icon'       => 'icon-plus',
	),
);

echo View_Helper::nav($nav, array('class' => 'nav-pills pull-right'));
