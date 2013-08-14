<?php

Lang::load('countries', true);
$countries = __('countries');

$first_name = $last_name = $address = $address2 = $city = $state = $zip = $email = $phone = null;
$country = 'US';

if (!empty($contact)) {
	$first_name = $contact->first_name;
	$last_name  = $contact->last_name;
	$address    = $contact->address;
	$address2   = $contact->address2;
	$city       = $contact->city;
	$state      = $contact->state;
	$zip        = $contact->zip;
	$country    = $contact->country;
	$email      = $contact->email;
	$phone      = $contact->phone;
}
?>

<?php echo Form::open(array('class' => 'form-horizontal form-validate')) ?>
	<div class="control-group<?php if (!empty($errors['first_name'])) echo ' error' ?>">
		<?php echo Form::label('First Name', 'first_name', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('first_name', Input::post('first_name', $first_name), array('class' => 'required')) ?>
			<?php if (!empty($errors['first_name'])) echo $errors['first_name'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['last_name'])) echo ' error' ?>">
		<?php echo Form::label('Last Name', 'last_name', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('last_name', Input::post('last_name', $last_name), array('class' => 'required')) ?>
			<?php if (!empty($errors['last_name'])) echo $errors['last_name'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['address'])) echo ' error' ?>">
		<?php echo Form::label('Address', 'address', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('address', Input::post('address', $address), array('class' => 'required')) ?>
			<?php if (!empty($errors['address'])) echo $errors['address'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['address2'])) echo ' error' ?>">
		<?php echo Form::label('Address 2', 'address2', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('address2', Input::post('address2', $address2)) ?>
			<?php if (!empty($errors['address2'])) echo $errors['address2'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['city'])) echo ' error' ?>">
		<?php echo Form::label('City', 'city', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('city', Input::post('city', $city), array('class' => 'required')) ?>
			<?php if (!empty($errors['city'])) echo $errors['city'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['state'])) echo ' error' ?>">
		<?php echo Form::label('State', 'state', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('state', Input::post('state', $state), array('class' => 'required')) ?>
			<?php if (!empty($errors['state'])) echo $errors['state'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['zip'])) echo ' error' ?>">
		<?php echo Form::label('Zip', 'zip', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('zip', Input::post('zip', $zip), array('class' => 'required')) ?>
			<?php if (!empty($errors['zip'])) echo $errors['zip'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['country'])) echo ' error' ?>">
		<?php echo Form::label('Country', 'country', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::select('country', Input::post('country', $country), $countries, array('class' => 'required')) ?>
			<?php if (!empty($errors['country'])) echo $errors['country'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['email'])) echo ' error' ?>">
		<?php echo Form::label('Email', 'email', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('email', Input::post('email', $email), array('class' => 'required')) ?>
			<?php if (!empty($errors['email'])) echo $errors['email'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['phone'])) echo ' error' ?>">
		<?php echo Form::label('Phone', 'phone', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('phone', Input::post('phone', $phone), array('class' => 'required')) ?>
			<?php if (!empty($errors['phone'])) echo $errors['phone'] ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php echo Html::anchor($customer->link('contacts'), __('form.cancel.label'), array('class' => 'btn')) ?>
		<?php echo Form::button('submit', __('form.submit.label'), array('class' => 'btn btn-primary')) ?>
	</div>
<?php echo Form::close() ?>
