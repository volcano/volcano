<?php

if (empty($customer) || empty($gateway)) {
	return;
}

Lang::load('countries', true);
$countries = __('countries');

$first_name = $last_name = $address = $address2 = $city = $state = $zip = $primary = null;
$country = 'US';

if (!empty($paymentmethod)) {
	$primary             = $paymentmethod->primary();
	$contact             = $paymentmethod->contact;
	$first_name          = $contact->first_name;
	$last_name           = $contact->last_name;
	$address             = $contact->address;
	$address2            = $contact->address2;
	$city                = $contact->city;
	$state               = $contact->state;
	$zip                 = $contact->zip;
	$country             = $contact->country;
}
?>

<?php echo Form::open(array('class' => 'form-horizontal form-validate')) ?>
	<?php if ($gateway->processes_credit_cards()): ?>
		<div class="control-group<?php if (!empty($errors['account.number'])) echo ' error' ?>">
			<?php echo Form::label('Credit Card Number', 'number', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo Form::input('account[number]', Input::post('account.number'), array('class' => 'required')) ?>
				<?php if (!empty($errors['account.number'])) echo $errors['account.number'] ?>
			</div>
		</div>
		
		<div class="control-group<?php if (!empty($errors['account.expiration_month'])) echo ' error' ?>">
			<?php echo Form::label('Expiration', 'expiration', array('class' => 'control-label')) ?>
			<div class="controls">
				<div class="input-prepend input-append">
					<?php
					echo Form::input(
						'account[expiration_month]',
						Input::post('account.expiration_month'),
						array('id' => 'prependedInput', 'class' => 'span1 required',  'placeholder' => 'MM','maxlength' => 2)
					);
					?>
					<span class="add-on">/</span>
					<?php
					echo Form::input(
						'account[expiration_year]',
						Input::post('account.expiration_year'),
						array('id' => 'appendedInput', 'class' => 'span1 required',  'placeholder' => 'YY','maxlength' => 2)
					);
					?>
				</div>
				<?php if (!empty($errors['account.expiration_month'])) echo $errors['account.expiration_month'] ?>
			</div>
		</div>
	<?php endif ?>
	
	<div class="control-group<?php if (!empty($errors['contact.first_name'])) echo ' error' ?>">
		<?php echo Form::label('First Name', 'first_name', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[first_name]', Input::post('contact.first_name', $first_name), array('class' => 'required')) ?>
			<?php if (!empty($errors['contact.first_name'])) echo $errors['contact.first_name'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.last_name'])) echo ' error' ?>">
		<?php echo Form::label('Last Name', 'last_name', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[last_name]', Input::post('contact.last_name', $last_name), array('class' => 'required')) ?>
			<?php if (!empty($errors['contact.last_name'])) echo $errors['contact.last_name'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.address'])) echo ' error' ?>">
		<?php echo Form::label('Address', 'address', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[address]', Input::post('contact.address', $address), array('class' => 'required')) ?>
			<?php if (!empty($errors['contact.address'])) echo $errors['contact.address'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.address2'])) echo ' error' ?>">
		<?php echo Form::label('Address 2', 'address2', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[address2]', Input::post('contact.address2', $address2)) ?>
			<?php if (!empty($errors['contact.address2'])) echo $errors['contact.address2'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.city'])) echo ' error' ?>">
		<?php echo Form::label('City', 'city', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[city]', Input::post('contact.city', $city), array('class' => 'required')) ?>
			<?php if (!empty($errors['contact.city'])) echo $errors['contact.city'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.state'])) echo ' error' ?>">
		<?php echo Form::label('State', 'state', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[state]', Input::post('contact.state', $state), array('class' => 'required')) ?>
			<?php if (!empty($errors['contact.state'])) echo $errors['contact.state'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.zip'])) echo ' error' ?>">
		<?php echo Form::label('Zip', 'zip', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::input('contact[zip]', Input::post('contact.zip', $zip), array('class' => 'required')) ?>
			<?php if (!empty($errors['contact.zip'])) echo $errors['contact.zip'] ?>
		</div>
	</div>
	
	<div class="control-group<?php if (!empty($errors['contact.country'])) echo ' error' ?>">
		<?php echo Form::label('Country', 'country', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo Form::select('contact[country]', Input::post('contact.country', $country), $countries, array('class' => 'required')) ?>
			<?php if (!empty($errors['contact.country'])) echo $errors['contact.country'] ?>
		</div>
	</div>
	
	<?php if (!$primary): ?>
		<div class="control-group">
			<div class="controls">
				<label class="checkbox">
					<?php echo Form::checkbox('primary', 1, Input::post('primary', $primary)) ?>
					Primary Payment Method
				</label>
			</div>
		</div>
	<?php endif ?>
	
	<div class="form-actions">
		<?php echo Html::anchor($customer->link('paymentmethods'), __('form.cancel.label'), array('class' => 'btn')) ?>
		<?php echo Form::button('submit', __('form.submit.label'), array('class' => 'btn btn-primary')) ?>
	</div>
<?php echo Form::close() ?>
