<?php
$layout->title = 'Create';
$layout->breadcrumbs['Settings'] = 'settings';
$layout->breadcrumbs['Event Callbacks'] = 'settings/callbacks';

echo render('settings/callbacks/form', array(
	'events' => $events,
	'errors' => !empty($errors) ? $errors : array(),
));
?>
