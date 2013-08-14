<?php
$layout->title = 'Edit';
$layout->subtitle = $contact->name();
$layout->breadcrumbs['Customers'] = 'customers';
$layout->breadcrumbs[$customer->name()] = $customer->link('contacts');
$layout->breadcrumbs['Contacts'] = $customer->link('contacts');
$layout->breadcrumbs['Edit: ' . $contact->name()] = '';

echo render('customers/contacts/form', array(
	'customer' => $customer,
	'contact'  => $contact,
	'errors'   => !empty($errors) ? $errors : array(),
));
?>
