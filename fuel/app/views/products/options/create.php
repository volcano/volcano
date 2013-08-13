<?php
$layout->title = 'Create Option';
$layout->breadcrumbs['Products'] = 'products';
$layout->breadcrumbs[$product->name] = $product->link('options');
$layout->breadcrumbs['Create Option'] = '';

echo render('products/options/form', array(
	'product' => $product,
	'errors'  => !empty($errors) ? $errors : array(),
));
?>
