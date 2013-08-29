<?php
$processor = Str::ucwords($gateway->processor);

$layout->title = 'Edit';
$layout->subtitle = $processor;
$layout->breadcrumbs['Settings'] = 'settings';
$layout->breadcrumbs['Gateways'] = 'settings/gateways';
$layout->breadcrumbs['Edit: ' . $processor] = '';

$types = array();
foreach (Arr::get($config, 'types') as $type) {
	$types[$type] = Inflector::titleize($type);
}

$processors = array();
foreach (Arr::get($config, 'processors') as $processor) {
	$processors[$processor] = Inflector::titleize($processor);
}
?>

<?php echo Form::open(array('class' => 'form-horizontal form-validate')) ?>
	<div class="control-group<?php if (!empty($errors['type'])) echo ' error' ?>">
		<?php echo Form::label('Type', 'type', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::select('type', Input::post('type', $gateway->type), $types, array('class' => 'required')) ?>
			<?php if (!empty($errors['type'])) echo $errors['type'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['processor'])) echo ' error' ?>">
		<?php echo Form::label('Processor', 'processor', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::select('processor', Input::post('processor', $gateway->processor), $processors, array('class' => 'required')) ?>
			<?php if (!empty($errors['processor'])) echo $errors['processor'] ?>
		</div>
	</div>
	
	<?php foreach ($gateway->meta() as $meta): ?>
		<div class="control-group">
			<?php echo Form::label(Inflector::titleize($meta->name), $meta->name, array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo Form::input("meta[{$meta->name}]", Input::post("meta.{$meta->name}", Crypt::decode($meta->value, $enc_key))) ?>
			</div>
		</div>
	<?php endforeach ?>
	
	<div class="form-actions">
		<?php echo Html::anchor('settings/gateways', __('form.cancel.label'), array('class' => 'btn')) ?>
		<?php echo Form::button('submit', __('form.submit.label'), array('class' => 'btn btn-primary')) ?>
	</div>
<?php echo Form::close() ?>
