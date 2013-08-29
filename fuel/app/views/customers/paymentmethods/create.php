<?php
$layout->title = 'Add Payment Method';
$layout->breadcrumbs['Customers'] = 'customers';
$layout->breadcrumbs[$customer->name()] = $customer->link('contacts');
$layout->breadcrumbs['Payment Methods'] = $customer->link('paymentmethods');
$layout->breadcrumbs['Add Payment Method'] = '';

echo render('customers/paymentmethods/form', array(
	'customer' => $customer,
	'contact'  => $contact,
	'gateway'  => $gateway,
	'errors'   => !empty($errors) ? $errors : array(),
));
?>
