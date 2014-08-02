<?php
$layout->title = 'Add Contact';
$layout->breadcrumbs['Settings'] = 'settings';
$layout->breadcrumbs['Contacts'] = 'settings/contacts';
$layout->breadcrumbs['Add Contact'] = '';

echo render('settings/contacts/form', array(
	'contact' => !empty($contact) ? $contact : null,
	'errors'  => !empty($errors) ? $errors : array(),
));
?>

