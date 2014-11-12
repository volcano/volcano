<?php

if (empty($product)) {
	return;
}

$name = null;
if (!empty($option)) {
	$name = $option->name;
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
	
	<?php foreach ($product_metas as $meta): ?>
		<div class="control-group">
			<?php echo Form::label($meta->name, 'meta-' . $meta->name, array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				$meta_options = array();
				foreach ($meta->options as $option) {
					$meta_options[$option->id] = $option->value;
				}
				echo Form::select("meta[{$meta->id}]", null, $meta_options)
				?>
			</div>
		</div>
	<?php endforeach ?>
	
	<div class="form-actions">
		<?php echo Html::anchor($product->link('options'), __('form.cancel.label'), array('class' => 'btn')) ?>
		<?php echo Form::button('submit', __('form.submit.label'), array('class' => 'btn btn-primary')) ?>
	</div>
<?php echo Form::close() ?>
