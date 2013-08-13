<?php
$layout->title = 'Edit';
$layout->subtitle = $product->name;
$layout->breadcrumbs['Products'] = 'products';
$layout->breadcrumbs['Edit: ' . $product->name] = '';

echo render('products/form', array(
	'product' => $product,
	'errors'  => !empty($errors) ? $errors : array(),
));
?>
