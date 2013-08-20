<?php
$layout->title = 'General';
$layout->breadcrumbs['Settings'] = 'settings';
$layout->breadcrumbs['General'] = '';
?>

<?php echo Form::open(array('class' => 'form-horizontal form-validate')) ?>
	<div class="control-group<?php if (!empty($errors['name'])) echo ' error' ?>">
		<?php echo Form::label('Name', 'name', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('name', Input::post('name', $seller->name), array('class' => 'required')) ?>
			<?php if (!empty($errors['name'])) echo $errors['name'] ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php echo Form::button('submit', __('form.submit.label'), array('class' => 'btn btn-primary')) ?>
	</div>
<?php echo Form::close() ?>
