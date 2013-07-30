<?php

/**
 * Authorize.net gateway payment method class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Gateway_Authorizenet_Paymentmethod extends Gateway_Core_Paymentmethod
{
	/**
	 * Finds a single instance.
	 * 
	 * @param int|array $options Instance identifier or filter data.
	 *
	 * @return array|null
	 */
	public function find_one($options = array())
	{
		$customer_gateway_id = Service_Customer_Gateway::external_id($this->driver->customer, $this->driver->gateway);
		if (!$customer_gateway_id) {
			return null;
		}
		
		if (is_numeric($options)) {
			$payment_method_id = $options;
		}
		
		$request = new AuthorizeNetCIM();
		
		$response = $request->getCustomerPaymentProfile($customer_gateway_id, $payment_method_id);
		
		if (!$response->isOk()) {
			Log::error('Unable to retrieve Authorize.net payment method.');
			return null;
		}
		
		$credit_card = $response->xml->paymentProfile->payment->creditCard;
		
		return array(
			'id'          => $response->getPaymentProfileId(),
			'customer_id' => $customer_gateway_id,
			'number'      => '****' . substr($credit_card->cardNumber, 4),
		);
	}
	
	/**
	 * Creates a new payment method.
	 *
	 * @param array $data The data to use to create the payment method.
	 *
	 * @return int|bool
	 */
	public function create(array $data)
	{
		$customer_gateway_id = Service_Customer_Gateway::external_id($this->driver->customer, $this->driver->gateway);
		if (!$customer_gateway_id) {
			return false;
		}
		
		if (!$credit_card = Arr::get($data, 'account')) {
			return false;
		}
		
		if (!$contact = Arr::get($data, 'contact')) {
			return false;
		}
		
		if (!$this->auth($credit_card)) {
			return false;
		}
		
		$request = new AuthorizeNetCIM();
		
		$payment_profile = new AuthorizeNetPaymentProfile();
		
		$payment_profile->payment->creditCard->cardNumber = preg_replace('/\D+/', '', $credit_card['number']);
		$payment_profile->payment->creditCard->expirationDate = '20' . $credit_card['expiration_year'] . '-' . $credit_card['expiration_month'];
		//$payment_profile->payment->creditCard->cardCode = $credit_card['cvv_code'];
		
		$payment_profile->billTo->firstName   = Arr::get($contact, 'first_name', '');
		$payment_profile->billTo->lastName    = Arr::get($contact, 'last_name', '');
		$payment_profile->billTo->address     = Arr::get($contact, 'address', '') . Arr::get($contact, 'address2', '');
		$payment_profile->billTo->city        = Arr::get($contact, 'city', '');
		$payment_profile->billTo->state       = Arr::get($contact, 'state', '');
		$payment_profile->billTo->zip         = Arr::get($contact, 'zip', '');
		$payment_profile->billTo->country     = Arr::get($contact, 'country', '');
		$payment_profile->billTo->phoneNumber = Arr::get($contact, 'phone', '');
		
		$response = $request->createCustomerPaymentProfile($customer_gateway_id, $payment_profile);
		
		if (!$response->isOk()) {
			Log::error('Unable to create Authorize.net payment method.');
			return false;
		}
		
		return $response->getPaymentProfileId();
	}
	
	/**
	 * Updates a payment method.
	 *
	 * @param array $data The data to use to update the payment method.
	 *
	 * @return bool
	 */
	public function update(array $data)
	{
		if (!$id = $this->id()) {
			return false;
		}
		
		if (!$customer_gateway_id = $this->data('customer_id')) {
			return false;
		}
		
		if (!$credit_card = Arr::get($data, 'account')) {
			return false;
		}
		
		if (!$contact = Arr::get($data, 'contact')) {
			return false;
		}
		
		if (!$this->auth($credit_card)) {
			return false;
		}
		
		$request = new AuthorizeNetCIM();
		
		$payment_profile = new AuthorizeNetPaymentProfile();
		
		$payment_profile->payment->creditCard->cardNumber = preg_replace('/\D+/', '', $credit_card['number']);
		$payment_profile->payment->creditCard->expirationDate = '20' . $credit_card['expiration_year'] . '-' . $credit_card['expiration_month'];
		//$payment_profile->payment->creditCard->cardCode = $credit_card['cvv_code'];
		
		$payment_profile->billTo->firstName = Arr::get($contact, 'first_name', '');
		$payment_profile->billTo->lastName = Arr::get($contact, 'last_name', '');
		$payment_profile->billTo->address = Arr::get($contact, 'address', '') . Arr::get($contact, 'address2', '');
		$payment_profile->billTo->city = Arr::get($contact, 'city', '');
		$payment_profile->billTo->state = Arr::get($contact, 'state', '');
		$payment_profile->billTo->zip = Arr::get($contact, 'zip', '');
		$payment_profile->billTo->country = Arr::get($contact, 'country', '');
		$payment_profile->billTo->phoneNumber = Arr::get($contact, 'phone', '');
		
		$response = $request->updateCustomerPaymentProfile($customer_gateway_id, $id, $payment_profile);
		
		if (!$response->isOk()) {
			dar($response);die;
			Log::error('Unable to update Authorize.net payment method.');
			return false;
		}
		
		return true;
	}
	
	/**
	 * Deletes a payment method.
	 *
	 * @return bool
	 */
	public function delete()
	{
		if (!$id = $this->id()) {
			return false;
		}
		
		if (!$customer_gateway_id = $this->data('customer_id')) {
			return false;
		}
		
		$request = new AuthorizeNetCIM();
		
		$response = $request->deleteCustomerPaymentProfile($customer_gateway_id, $id);
		
		if (!$response->isOk()) {
			Log::error('Unable to delete Authorize.net payment method.');
			return false;
		}
		
		return true;
	}
	
	/**
	 * Validates the provided credit card data by posting a temporary $1.00 authorization charge.
	 *
	 * @param array $data The credit card data to use to verify.
	 *
	 * @return bool
	 */
	public function auth(array $data)
	{
		$authorize_aim = new AuthorizeNetAIM();
		$authorize_aim->amount = 1.00;
		$authorize_aim->card_num = $data['number'];
		$authorize_aim->exp_date = $data['expiration_month'] . '/' . $data['expiration_year'];
		$authorize_aim->allow_partial_auth = true;
		
		$response = $authorize_aim->authorizeOnly();
		
		if ($response->approved == true) {
			return true;
		}
		
		Log::error('Authorize.net auth transaction failed.');
		
		return false;
	}
}
