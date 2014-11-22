<?php
$layout->title = 'Edit';
$layout->subtitle = $meta->name;
$layout->breadcrumbs['Product Lines'] = 'products';
$layout->breadcrumbs[$product->name] = $product->link('edit');
$layout->breadcrumbs['Metas'] = $product->link('metas');
$layout->breadcrumbs['Edit: ' . $meta->name] = '';

echo render('products/metas/form', array(
	'product' => $product,
	'meta'    => $meta,
	'errors'  => !empty($errors) ? $errors : array(),
));
?>
