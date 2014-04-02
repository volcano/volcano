<?php

/**
 * Customer transaction service.
 */
class Service_Customer_Transaction extends Service
{
	/**
	 * Query models based on optional filters passed in.
	 *
	 * @param array $options The optional options to use.
	 *
	 * @return Query
	 */
	protected static function query(array $options = array())
	{
		$transactions = Model_Customer_Transaction::query();
		
		if (!empty($options['id'])) {
			$transactions->where('id', $options['id']);
		}
		
		if (!empty($options['customer'])) {
			$transactions->where('customer_id', $options['customer']->id);
		}
		
		if (!empty($options['status'])) {
			$transactions->where('status', $options['status']);
		}
		
		return $transactions;
	}
	
	/**
	 * Creates a new customer transaction.
	 *
	 * @param Model_Customer_Paymentmethod $payment_method The payment method.
	 * @param string                       $amount         The amount to transact.
	 * @param array                        $data           Optional data.
	 *
	 * @return Model_Customer_Transaction
	 */
	public static function create(Model_Customer_Paymentmethod $payment_method, $amount, array $data = array())
	{
		$gateway_instance = Gateway::instance($payment_method->gateway, $payment_method->customer);
		if ($gateway_instance) {
			$external_id = $gateway_instance->transaction()->create(array(
				'payment_method' => $payment_method,
				'amount'         => $amount,
			));
			
			if (!$external_id) {
				return false;
			}
		} else {
			$external_id = null;
		}
		
		$transaction = Model_Customer_Transaction::forge();
		$transaction->customer    = $payment_method->customer;
		$transaction->gateway     = $payment_method->gateway;
		$transaction->external_id = $external_id;
		$transaction->type        = $payment_method->gateway->type;
		$transaction->provider    = $payment_method->provider;
		$transaction->account     = $payment_method->account;
		$transaction->amount      = $amount;
		
		try {
			$transaction->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		Service_Event::trigger(
			'customer.transaction.create',
			$transaction->customer->seller,
			$transaction->to_array()
		);
		
		return $transaction;
	}
}
