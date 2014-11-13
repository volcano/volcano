<?php

if (empty($option)) {
	return;
}

$nav = array(
	array(
		'href'  => $option->product->link('options'),
		'value' => 'Configure Options',
		'class' => 'return-link',
	),
	array(
		'href'  => $option->link('edit'),
		'value' => 'General',
	),
	array(
		'href'  => $option->link('fees'),
		'value' => 'Fees',
	),
);

echo View_Helper::nav($nav);
