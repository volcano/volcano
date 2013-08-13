<?php

if (empty($option)) {
	return;
}

$nav = array(
	array(
		'href'       => $option->link('fees/create'),
		'value'      => 'Create Fee',
		'attributes' => array('class' => 'btn'),
		'icon'       => 'icon-plus',
	),
);

echo View_Helper::nav($nav, array('class' => 'nav-pills pull-right'));
