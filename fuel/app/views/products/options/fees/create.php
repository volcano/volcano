<?php
$layout->title = 'Add Fee';
$layout->breadcrumbs['Product Lines'] = 'products';
$layout->breadcrumbs[$product->name] = $product->link('options');
$layout->breadcrumbs[$option->name] = $option->link('fees');
$layout->breadcrumbs['Add Fee'] = '';

echo render('products/options/fees/form', array(
	'option' => $option,
	'errors' => !empty($errors) ? $errors : array(),
));
?>
