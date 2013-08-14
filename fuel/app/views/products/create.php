<?php
$layout->title = 'Add Product';
$layout->breadcrumbs['Products'] = 'products';
$layout->breadcrumbs['Add Product'] = '';

echo render('products/form', array(
	'errors' => !empty($errors) ? $errors : array(),
));
?>
