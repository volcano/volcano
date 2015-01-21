<?php
$layout->title = 'Add Fee';
$layout->breadcrumbs['Product Lines'] = 'products';
$layout->breadcrumbs[$product->name] = $product->link('edit');
$layout->breadcrumbs['Options'] = $product->link('options');
$layout->breadcrumbs[$option->name] = $option->link('edit');
$layout->breadcrumbs['Fees'] = $option->link('fees');
$layout->breadcrumbs['Add Fee'] = '';

echo render('products/options/fees/form', array(
	'option' => $option,
	'errors' => !empty($errors) ? $errors : array(),
));
?>
