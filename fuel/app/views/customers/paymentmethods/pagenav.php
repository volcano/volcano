<?php

if (empty($customer)) {
	return;
}

$nav = array(
	array(
		'href'       => $customer->link('paymentmethods/create'),
		'value'      => 'Add Payment Method',
		'attributes' => array('class' => 'btn'),
		'icon'       => 'icon-plus',
	),
);

echo View_Helper::nav($nav, array('class' => 'nav-pills pull-right'));
