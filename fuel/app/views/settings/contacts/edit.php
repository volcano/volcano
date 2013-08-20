<?php
$layout->title = 'Edit';
$layout->subtitle = $contact->company_name;
$layout->breadcrumbs['Contacts'] = 'settings';
$layout->breadcrumbs['Edit: ' . $contact->company_name] = '';

echo render('settings/contacts/form', array(
	'contact' => $contact,
	'errors'  => !empty($errors) ? $errors : array(),
));
?>
