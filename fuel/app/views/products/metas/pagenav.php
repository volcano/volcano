<?php

if (empty($product)) {
	return;
}

$nav = array(
	array(
		'href'       => $product->link('metas/create'),
		'value'      => 'Add Meta',
		'attributes' => array('class' => 'btn'),
		'icon'       => 'icon-plus',
	),
);

echo View_Helper::nav($nav, array('class' => 'nav-pills pull-right'));
