<?php
if (empty($product)) {
	return;
}

$meta = !empty($meta) ? $meta : null;

// Reset the array keys so we can more easily iterate through them.
$options = $meta ? array_values($meta->options) : array();
?>

<?php echo Form::open(array('class' => 'form-horizontal form-validate')) ?>
	<div class="control-group<?php if (!empty($errors['name'])) echo ' error' ?>">
		<?php echo Form::label('Name', 'name', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('name', Input::post('name', $meta ? $meta->name : null), array('class' => 'required')) ?>
			<?php if (!empty($errors['name'])) echo $errors['name'] ?>
		</div>
	</div>
	
	<div class="control-group control-group-vertical">
		<?php echo Form::label('Options', 'Options', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php
			$options_limit = ($options ? count($options) : 0) + 5;
			for ($i = 1; $i <= $options_limit; $i++) {
				$option       = $meta ? Arr::get($options, $i - 1) : null;
				$option_key   = $option ? $option->id : null;
				$option_value = $option ? $option->value : null;
				
				echo Form::input("value[$option_key]", Input::post("value[$option_key]", $option_value), array('placeholder' => "Option $i"));
			}
			?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php echo Html::anchor($product->link('metas'), __('form.cancel.label'), array('class' => 'btn')) ?>
		<?php echo Form::button('submit', __('form.submit.label'), array('class' => 'btn btn-primary')) ?>
	</div>
<?php echo Form::close() ?>
