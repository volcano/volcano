<?php
$layout->title = 'Add Seller';

echo render('setup/form', array(
	'errors' => !empty($errors) ? $errors : array(),
));
?>
