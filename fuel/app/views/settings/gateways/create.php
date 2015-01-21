<?php
$layout->title = 'Add Gateway';
$layout->breadcrumbs['Settings'] = 'settings';
$layout->breadcrumbs['Gateways'] = 'settings/gateways';
$layout->breadcrumbs['Add Gateway'] = '';

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
			<?php echo Form::select('type', Input::post('type'), $types, array('class' => 'required')) ?>
			<?php if (!empty($errors['type'])) echo $errors['type'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['processor'])) echo ' error' ?>">
		<?php echo Form::label('Processor', 'processor', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::select('processor', Input::post('processor'), $processors, array('class' => 'required')) ?>
			<?php if (!empty($errors['processor'])) echo $errors['processor'] ?>
		</div>
	</div>
	
	<div id="meta-fields">
		<?php for ($i = 1; $i <= 5; $i++): ?>
			<div class="control-group<?php if ($i > 1) echo ' hide' ?>">
				<?php echo Form::label('Meta', 'meta', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo Form::input("meta[$i][name]", null, array('placeholder' => 'Name')) ?>
					<?php echo Form::input("meta[$i][value]", null, array('placeholder' => 'Value')) ?>
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
		<?php echo Html::anchor('settings/gateways', __('form.cancel.label'), array('class' => 'btn')) ?>
		<?php echo Form::button('submit', __('form.submit.label'), array('class' => 'btn btn-primary')) ?>
	</div>
<?php echo Form::close() ?>
