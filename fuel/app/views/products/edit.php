<?php
$layout->title = 'General';
$layout->subtitle = $product->name;
$layout->leftnav = render('products/leftnav', array('product' => $product));
$layout->breadcrumbs['Product Lines'] = 'products';
$layout->breadcrumbs[$product->name] = $product->link('edit');
$layout->breadcrumbs['General'] = '';

echo render('products/form', array(
	'product' => $product,
	'errors'  => !empty($errors) ? $errors : array(),
));
?>
