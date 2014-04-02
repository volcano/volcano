<?php

/**
 * Authorize.net gateway transaction class.
 */
class Gateway_Authorizenet_Transaction extends Gateway_Core_Transaction
{
	/**
	 * Authorize.Net's transaction status associations.
	 *
	 * @see https://support.authorize.net/authkb/index?page=content&id=A136
	 *
	 * @var array
	 */
	public $statuses = array(
		'capturedPendingSettlement' => 'paid',
		'pendingSettlement'         => 'paid',
		'settledSuccessfully'       => 'paid',
		'declined'                  => 'declined',
		'refundPendingSettlement'   => 'refunded',
		'refundSettledSuccessfully' => 'refunded',
	);
	
	/**
	 * Finds a single instance.
	 * 
	 * @param int|array $options Instance identifier or filter data.
	 *
	 * @return array|null
	 */
	public function find_one($options = array())
	{
		if (is_numeric($options)) {
			$transaction_id = $options;
		}
		
		$request = new AuthorizeNetTD();
		$response = $request->getTransactionDetails($transaction_id);
		
		if (!$response->isOk()) {
			Log::error('Unable to retrieve Authorize.net transaction.');
			return false;
		}
		
		$transaction = $response->xml->transaction;
		
		return array(
			'id'     => $transaction_id,
			'amount' => $transaction->authAmount,
			'status' => Arr::get($this->statuses, $transaction->transactionStatus, 'error'),
		);
	}
	
	/**
	 * Creates a new instance.
	 *
	 * @param $data New instance data.
	 *
	 * @return bool
	 */
	public function create(array $data)
	{
		$customer_gateway_id = Service_Customer_Gateway::external_id($this->driver->customer, $this->driver->gateway);
		if (!$customer_gateway_id) {
			return false;
		}
		
		if (!$payment_method = Arr::get($data, 'payment_method')) {
			return false;
		}
		
		if (!$amount = Arr::get($data, 'amount')) {
			return false;
		}
		
		$request = new AuthorizeNetCIM();
		
		$transaction = new AuthorizeNetTransaction();
		
		$transaction->amount = $amount;
		$transaction->customerProfileId = $customer_gateway_id;
		$transaction->customerPaymentProfileId = $payment_method->external_id;
		
		// AuthOnly or AuthCapture
		$response = $request->createCustomerProfileTransaction('AuthCapture', $transaction);
		
		if (!$response->isOk()) {
			Log::error('Unable to create Authorize.net transaction.');
			return false;
		}
		
		$response = $response->getTransactionResponse();
		if (empty($response->transaction_id)) {
			return false;
		}
		
		return $response->transaction_id;
	}
	
	/**
	 * Updates an existing instance.
	 * 
	 * @param array $data Updated instance data.
	 *
	 * @return bool
	 */
	public function update(array $data) {}
	
	/**
	 * Deletes an existing instance.
	 *
	 * @return bool
	 */
	public function delete() {}
}
