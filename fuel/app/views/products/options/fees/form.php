<?php

if (empty($option)) {
	return;
}

Config::load('fee', true);

$config = Config::get('fee');

$intervals = array();
foreach ($config['intervals'] as $interval) {
	$intervals[$interval] = $interval;
}

$interval_units = array();
foreach ($config['interval_units'] as $unit) {
	$interval_units[$unit] = Str::ucfirst($unit);
}

$name = $interval = $interval_unit = $interval_price = null;

if (!empty($fee)) {
	$name                = $fee->name;
	$interval            = $fee->interval;
	$interval_unit       = $fee->interval_unit;
	$interval_price      = $fee->interval_price;
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
	
	<div class="control-group<?php if (!empty($errors['interval'])) echo ' error' ?>">
		<?php echo Form::label('Interval', 'interval', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::select('interval', Input::post('interval', $interval), $intervals, array('class' => 'input-small required')) ?>
			<?php if (!empty($errors['interval'])) echo $errors['interval'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['interval_unit'])) echo ' error' ?>">
		<?php echo Form::label('Interval Unit', 'interval_unit', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::select('interval_unit', Input::post('interval_unit', $interval_unit), $interval_units, array('class' => 'input-medium required')) ?>
			<?php if (!empty($errors['interval_unit'])) echo $errors['interval_unit'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['interval_price'])) echo ' error' ?>">
		<?php echo Form::label('Interval Price', 'interval_price', array('class' => 'control-label')) ?>
		<div class="controls">
			<div class="input-prepend">
				<span class="add-on">$</span>
				<?php echo Form::input('interval_price', Input::post('interval_price', $interval_price), array('id' => 'prependedInput', 'class' => 'input-small required')) ?>
				<?php if (!empty($errors['interval_price'])) echo $errors['interval_price'] ?>
			</div>
		</div>
	</div>
	
	<div class="form-actions">
		<?php echo Html::anchor($option->link('fees'), __('form.cancel.label'), array('class' => 'btn')) ?>
		<?php echo Form::button('submit', __('form.submit.label'), array('class' => 'btn btn-primary')) ?>
	</div>
<?php echo Form::close() ?>
