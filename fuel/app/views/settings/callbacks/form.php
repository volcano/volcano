<?php

$event_name = $url = null;

if (!empty($callback)) {
	$event_name = $callback->event->name;
	$url        = $callback->url;
}

$event_options = array();
foreach ($events as $event) {
	$event_options[$event->name] = $event;
}
?>

<?php echo Form::open(array('class' => 'form-horizontal form-validate')) ?>
	<div class="control-group<?php if (!empty($errors['event'])) echo ' error' ?>">
		<?php echo Form::label('Event', 'event', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::select('event', Input::post('event', $event_name), $event_options, array('class' => 'required')) ?>
			<?php if (!empty($errors['event'])) echo $errors['event'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['url'])) echo ' error' ?>">
		<?php echo Form::label('Callback URL', 'url', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('url', Input::post('url', $url), array('class' => 'input-xxlarge required')) ?>
			<?php if (!empty($errors['url'])) echo $errors['url'] ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php echo Html::anchor('settings/callbacks', __('form.cancel.label'), array('class' => 'btn')) ?>
		<?php echo Form::button('submit', __('form.submit.label'), array('class' => 'btn btn-primary')) ?>
	</div>
<?php echo Form::close() ?>
