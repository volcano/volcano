<?php

$submit_button_label = 'Create';
$name = null;

if (!empty($product)) {
	$submit_button_label = 'Save';
	$name = $product->name;
}
?>

<?php echo Form::open(array('class' => 'form-horizontal form-validate')) ?>
	<div class="control-group<?php if (!empty($errors['name'])) echo ' error' ?>">
		<?php echo Form::label('Name', 'name', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('name', Input::post('name', $name), array('class' => 'required')) ?>
			<?php if (!empty($errors['name'])) echo $errors['name'] ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php echo Html::anchor('products', 'Cancel', array('class' => 'btn')) ?>
		<?php echo Form::button('submit', $submit_button_label, array('class' => 'btn btn-primary')) ?>
	</div>
<?php echo Form::close() ?>
