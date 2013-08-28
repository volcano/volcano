<?php

if (empty($customer)) {
	return;
}

$nav = array(
	array(
		'href'  => 'customers',
		'value' => 'Manage Customers',
		'class' => 'return-link',
	),
	array(
		'href'  => $customer->link('contacts'),
		'value' => 'Contacts',
	),
	array(
		'href'  => $customer->link('paymentmethods'),
		'value' => 'Payment Methods',
	),
	array(
		'href'  => $customer->link('orders'),
		'value' => 'Orders',
	),
	array(
		'href'  => $customer->link('products'),
		'value' => 'Products',
	),
	array(
		'href'  => $customer->link('transactions'),
		'value' => 'Transactions',
	),
);

echo View_Helper::nav($nav);
