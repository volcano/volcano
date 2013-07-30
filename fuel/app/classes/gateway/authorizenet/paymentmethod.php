<?php

/**
 * Authorize.net gateway payment method class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Gateway_Authorizenet_Payment_Method extends Gateway_Core_Payment_Method
{
	/**
	 * Finds a single instance.
	 * 
	 * @param int|array $options Instance identifier or filter data.
	 *
	 * @return array|null
	 */
	public function find_one($options = array()) {}
	
	/**
	 * Creates a new payment method.
	 *
	 * @param array $data The data to use to create the payment method.
	 *
	 * @return bool
	 */
	public function create(array $data)
	{
		if (!$this->auth_transaction($data)) {
			return false;
		}
		
		if (!$profile_id = Arr::get($data, 'profile_id')) {
			return false;
		}
		
		$request = new AuthorizeNetCIM();
		
		$payment_profile = new AuthorizeNetPaymentProfile();
		
		$payment_profile->billTo->firstName   = Arr::get($data, 'first_name', '');
		$payment_profile->billTo->lastName    = Arr::get($data, 'last_name', '');
		$payment_profile->billTo->company     = Arr::get($data, 'company', '');
		$payment_profile->billTo->address     = Arr::get($data, 'address', '') . Arr::get($data, 'address2', '');
		$payment_profile->billTo->city        = Arr::get($data, 'city', '');
		$payment_profile->billTo->state       = Arr::get($data, 'state', '');
		$payment_profile->billTo->zip         = Arr::get($data, 'zip_code', '');
		$payment_profile->billTo->country     = Arr::get($data, 'country', '');
		$payment_profile->billTo->phoneNumber = Arr::get($data, 'phone_number', '');
		$payment_profile->billTo->faxNumber   = Arr::get($data, 'fax_number', '');
		
		$payment_profile->payment->creditCard->cardNumber = preg_replace('/\D+/', '', $data['card_number']);
		$payment_profile->payment->creditCard->expirationDate = '20' . $data['card_exp_year'] . '-' . $data['card_exp_month'];
		//$payment_profile->payment->creditCard->cardCode = $data['cvv_code'];
		
		$response = $request->createCustomerPaymentProfile($profile_id, $payment_profile);
		
		if (!$response->isOk()) {
			Log::error('Unable to create Authorize.net payment profile.');
			return false;
		}
		
		return $response->getPaymentProfileId();
	}
	
	/**
	 * Updates a payment method.
	 *
	 * @param int   $payment_profile_id The payment profile ID to update.
	 * @param array $data               The data to use to update the payment method.
	 *
	 * @return bool
	 */
	public function update($payment_profile_id, array $data)
	{
		if (!$this->auth_transaction($data)) {
			return false;
		}
		
		if (!$profile_id = Arr::get($data, 'profile_id')) {
			return false;
		}
		
		// @TODO Get $payment_profile_id from $this->id().
		
		$request = new AuthorizeNetCIM();
		
		$payment_profile = new AuthorizeNetPaymentProfile();
		
		$payment_profile->billTo->firstName = Arr::get($data, 'first_name', '');
		$payment_profile->billTo->lastName = Arr::get($data, 'last_name', '');
		$payment_profile->billTo->company = Arr::get($data, 'company', '');
		$payment_profile->billTo->address = Arr::get($data, 'address', '') . Arr::get($data, 'address2', '');
		$payment_profile->billTo->city = Arr::get($data, 'city', '');
		$payment_profile->billTo->state = Arr::get($data, 'state', '');
		$payment_profile->billTo->zip = Arr::get($data, 'zip_code', '');
		$payment_profile->billTo->country = Arr::get($data, 'country', '');
		$payment_profile->billTo->phoneNumber = Arr::get($data, 'phone_number', '');
		$payment_profile->billTo->faxNumber = Arr::get($data, 'fax_number', '');
		
		$payment_profile->payment->creditCard->cardNumber = preg_replace('/\D+/', '', $data['card_number']);
		$payment_profile->payment->creditCard->expirationDate = '20' . $data['card_exp_year'] . '-' . $data['card_exp_month'];
		//$payment_profile->payment->creditCard->cardCode = $data['cvv_code'];
		
		$response = $request->updateCustomerPaymentProfile($profile_id, $payment_profile_id, $payment_profile);
		
		if (!$response->isOk()) {
			Log::error('Unable to update Authorize.net payment profile.');
			return false;
		}
		
		return true;
	}
	
	/**
	 * Deletes a payment method.
	 *
	 * @param int $profile_id         The profile ID to use.
	 * @param int $payment_profile_id The payment method ID to delete.
	 *
	 * @return bool
	 */
	public function delete($profile_id, $payment_profile_id)
	{
		// @TODO Get $payment_profile_id from $this->id().
		
		$request = new AuthorizeNetCIM();
		
		$response = $request->deleteCustomerPaymentProfile($profile_id, $payment_profile_id);
		
		if (!$response->isOk()) {
			Log::error('Unable to delete Authorize.net payment profile.');
			return false;
		}
		
		return $this->driver->gateway()->update_gateway_id('', $data['client_id']);
	}
}
