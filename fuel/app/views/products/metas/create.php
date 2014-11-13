<?php
$layout->title = 'Add Meta';
$layout->breadcrumbs['Product Lines'] = 'products';
$layout->breadcrumbs[$product->name] = $product->link('edit');
$layout->breadcrumbs['Metas'] = $product->link('metas');
$layout->breadcrumbs['Add Meta'] = '';

echo render('products/metas/form', array(
	'product' => $product,
	'errors'  => !empty($errors) ? $errors : array(),
));
?>
