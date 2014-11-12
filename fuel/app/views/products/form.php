<?php

$name = null;

if (!empty($product)) {
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
	
	<div id="meta-fields">
		<?php for ($i = 1; $i <= 5; $i++): ?>
			<div class="control-group control-group-vertical<?php if ($i > 1) echo ' hide' ?>">
				<?php echo Form::label('Meta', 'meta', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo Form::input("meta[$i][name]", null, array('placeholder' => 'Name')) ?>
					<?php echo Form::input("meta[$i][value][]", null, array('placeholder' => 'Value 1')) ?>
					<?php echo Form::input("meta[$i][value][]", null, array('placeholder' => 'Value 2')) ?>
					<?php echo Form::input("meta[$i][value][]", null, array('placeholder' => 'Value 3')) ?>
					<?php echo Form::input("meta[$i][value][]", null, array('placeholder' => 'Value 4')) ?>
					<?php echo Form::input("meta[$i][value][]", null, array('placeholder' => 'Value 5')) ?>
				</div>
			</div>
		<?php endfor ?>
	</div>
	
	<div class="control-group">
		<div class="controls">
			<?php echo Html::anchor('javascript:void(0)', 'Add Another Meta', array('id' => 'add-meta')) ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php echo Html::anchor('products', __('form.cancel.label'), array('class' => 'btn')) ?>
		<?php echo Form::button('submit', __('form.submit.label'), array('class' => 'btn btn-primary')) ?>
	</div>
<?php echo Form::close() ?>
