<?php
$layout->title = 'Create Fee';
$layout->breadcrumbs['Products'] = 'products';
$layout->breadcrumbs[$product->name] = $product->link('options');
$layout->breadcrumbs[$option->name] = $option->link('fees');
$layout->breadcrumbs['Create Fee'] = '';

echo render('products/options/fees/form', array(
	'option' => $option,
	'errors' => !empty($errors) ? $errors : array(),
));
?>
