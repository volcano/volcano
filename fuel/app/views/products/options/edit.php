<?php
$layout->title = 'Edit';
$layout->subtitle = $option->name;
$layout->breadcrumbs['Product Lines'] = 'products';
$layout->breadcrumbs[$product->name] = $product->link('options');
$layout->breadcrumbs['Edit: ' . $option->name] = '';

echo render('products/options/form', array(
	'product' => $product,
	'option'  => $option,
	'errors'  => !empty($errors) ? $errors : array(),
));
?>
