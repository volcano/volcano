<?php

if (empty($product)) {
	return;
}

$nav = array(
	array(
		'href'  => 'products',
		'value' => 'Configure Products',
		'class' => 'return-link',
	),
	array(
		'href'  => $product->link('edit'),
		'value' => 'General',
	),
	array(
		'href'  => $product->link('metas'),
		'value' => 'Metas',
	),
	array(
		'href'  => $product->link('options'),
		'value' => 'Options',
	),
);

echo View_Helper::nav($nav);
