<?php
$layout->title = 'Add Product Line';
$layout->breadcrumbs['Product Lines'] = 'products';
$layout->breadcrumbs['Add Product Line'] = '';

echo render('products/form', array(
	'errors' => !empty($errors) ? $errors : array(),
));
?>
