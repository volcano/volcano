<?php

if (empty($customer)) {
	return;
}

$nav = array(
	array(
		'href'  => $customer->link('contacts'),
		'value' => 'Contacts',
	),
	array(
		'href'  => $customer->link('paymentmethods'),
		'value' => 'Payment Methods',
	),
	array(
		'href'  => $customer->link('transactions'),
		'value' => 'Transactions',
	),
);

echo View_Helper::nav($nav, array('class' => 'nav-pills pull-right'));
