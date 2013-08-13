<?php
$layout->title = 'Create Product';
$layout->breadcrumbs['Products'] = 'products';
$layout->breadcrumbs['Create Product'] = '';

echo render('products/form', array(
	'errors' => !empty($errors) ? $errors : array(),
));
?>
