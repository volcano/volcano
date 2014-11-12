<?php
$layout->title = 'Add Option';
$layout->breadcrumbs['Product Lines'] = 'products';
$layout->breadcrumbs[$product->name] = $product->link('options');
$layout->breadcrumbs['Add Option'] = '';

echo render('products/options/form', array(
	'product'       => $product,
	'product_metas' => $product_metas,
	'errors'        => !empty($errors) ? $errors : array(),
));
?>
