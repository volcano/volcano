<?php
$layout->title = 'Edit Fee';
$layout->subtitle = $fee->name;
$layout->breadcrumbs['Product Lines'] = 'products';
$layout->breadcrumbs[$product->name] = $product->link('edit');
$layout->breadcrumbs['Options'] = $product->link('options');
$layout->breadcrumbs[$option->name] = $option->link('edit');
$layout->breadcrumbs['Fees'] = $option->link('fees');
$layout->breadcrumbs['Edit Fee: ' . $fee->name] = '';

echo render('products/options/fees/form', array(
	'option' => $option,
	'fee'    => $fee,
	'errors' => !empty($errors) ? $errors : array(),
));
?>
