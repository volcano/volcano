<?php
if (empty($product)) {
	return;
}

$option = !empty($option) ? $option : null;
$metas  = $option ? $option->metas : array();
?>

<?php echo Form::open(array('class' => 'form-horizontal form-validate')) ?>
	<div class="control-group<?php if (!empty($errors['name'])) echo ' error' ?>">
		<?php echo Form::label('Name', 'name', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('name', Input::post('name', $option ? $option->name : null), array('class' => 'required')) ?>
			<?php if (!empty($errors['name'])) echo $errors['name'] ?>
		</div>
	</div>
	
	<?php foreach ($product->metas as $meta): ?>
		<div class="control-group">
			<?php echo Form::label($meta->name, 'meta-' . $meta->name, array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				$meta_options = array();
				foreach ($meta->options as $meta_option) {
					$meta_options[$meta_option->id] = $meta_option->value;
				}
				
				// Alphabetize the meta options.
				asort($meta_options);
				
				$product_meta_value = null;
				$option_metas       = $option ? $option->metas : array();
				foreach ($option_metas as $option_meta) {
					if ($option_meta->product_meta_id == $meta->id) {
						$product_meta_value = $option_meta->id;
						break;
					}
				}
				
				echo Form::select("meta[{$meta->id}]", Input::post("meta[{$meta->id}]", $product_meta_value), $meta_options);
				?>
			</div>
		</div>
	<?php endforeach ?>
	
	<div class="form-actions">
		<?php if (empty($option)): ?>
			<?php echo Html::anchor($product->link('options'), __('form.cancel.label'), array('class' => 'btn')) ?>
		<?php endif ?>
		
		<?php echo Form::button('submit', __('form.submit.label'), array('class' => 'btn btn-primary')) ?>
	</div>
<?php echo Form::close() ?>
