<?php
$layout->title = 'Edit';
$layout->subtitle = $paymentmethod->account();
$layout->breadcrumbs['Customers'] = 'customers';
$layout->breadcrumbs[$customer->name()] = $customer->link('contacts');
$layout->breadcrumbs['Payment Methods'] = $customer->link('paymentmethods');
$layout->breadcrumbs['Edit: ' . $paymentmethod->account()] = '';

echo render('customers/paymentmethods/form', array(
	'customer'      => $customer,
	'gateway'       => $paymentmethod->gateway,
	'paymentmethod' => $paymentmethod,
	'errors'        => !empty($errors) ? $errors : array(),
));
?>
