<?php
$layout->title = 'Edit';
$layout->subtitle = $callback->event;
$layout->breadcrumbs['Settings'] = 'settings';
$layout->breadcrumbs['Event Callbacks'] = 'settings/callbacks';
$layout->breadcrumbs['Edit: ' . $callback->event] = '';

echo render('settings/callbacks/form', array(
	'events'   => $events,
	'callback' => $callback,
	'errors'   => !empty($errors) ? $errors : array(),
));
?>
