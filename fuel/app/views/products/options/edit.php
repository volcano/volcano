<?php
$product = $option->product;

$layout->title = 'General';
$layout->subtitle = $option->name;
$layout->leftnav = render('products/options/leftnav', array('option' => $option));
$layout->breadcrumbs['Product Lines'] = 'products';
$layout->breadcrumbs[$product->name] = $product->link('edit');
$layout->breadcrumbs['Options'] = $product->link('options');
$layout->breadcrumbs[$option->name] = $option->link('edit');
$layout->breadcrumbs['General'] = '';

echo render('products/options/form', array(
	'product' => $product,
	'option'  => $option,
	'errors'  => !empty($errors) ? $errors : array(),
));
?>
