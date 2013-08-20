<?php

Lang::load('countries', true);
$countries = __('countries');

?>

<?php echo Form::open(array('class' => 'form-horizontal form-validate')) ?>
	<div class="control-group<?php if (!empty($errors['name'])) echo ' error' ?>">
		<?php echo Form::label('Name', 'name', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('name', Input::post('name'), array('class' => 'required')) ?>
			<?php if (!empty($errors['name'])) echo $errors['name'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.company_name'])) echo ' error' ?>">
		<?php echo Form::label('Company Name', 'company_name', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[company_name]', Input::post('contact.company_name'), array('class' => 'required')) ?>
			<?php if (!empty($errors['contact.company_name'])) echo $errors['contact.company_name'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.address'])) echo ' error' ?>">
		<?php echo Form::label('Address', 'address', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[address]', Input::post('contact.address')) ?>
			<?php if (!empty($errors['contact.address'])) echo $errors['contact.address'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.address2'])) echo ' error' ?>">
		<?php echo Form::label('Address 2', 'address2', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[address2]', Input::post('contact.address2')) ?>
			<?php if (!empty($errors['contact.address2'])) echo $errors['contact.address2'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.city'])) echo ' error' ?>">
		<?php echo Form::label('City', 'city', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[city]', Input::post('contact.city')) ?>
			<?php if (!empty($errors['contact.city'])) echo $errors['contact.city'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.state'])) echo ' error' ?>">
		<?php echo Form::label('State', 'state', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[state]', Input::post('contact.state')) ?>
			<?php if (!empty($errors['contact.state'])) echo $errors['contact.state'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.zip'])) echo ' error' ?>">
		<?php echo Form::label('Zip', 'zip', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[zip]', Input::post('contact.zip')) ?>
			<?php if (!empty($errors['contact.zip'])) echo $errors['contact.zip'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.country'])) echo ' error' ?>">
		<?php echo Form::label('Country', 'country', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::select('contact[country]', Input::post('contact.country', 'US'), $countries) ?>
			<?php if (!empty($errors['contact.country'])) echo $errors['contact.country'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.email'])) echo ' error' ?>">
		<?php echo Form::label('Email', 'email', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[email]', Input::post('contact.email'), array('class' => 'required')) ?>
			<?php if (!empty($errors['contact.email'])) echo $errors['contact.email'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.phone'])) echo ' error' ?>">
		<?php echo Form::label('Phone', 'phone', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[phone]', Input::post('contact.phone')) ?>
			<?php if (!empty($errors['contact.phone'])) echo $errors['contact.phone'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.fax'])) echo ' error' ?>">
		<?php echo Form::label('Fax', 'fax', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[fax]', Input::post('contact.fax')) ?>
			<?php if (!empty($errors['contact.fax'])) echo $errors['contact.fax'] ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php echo Form::button('submit', __('form.submit.label'), array('class' => 'btn btn-primary')) ?>
	</div>
<?php echo Form::close() ?>
