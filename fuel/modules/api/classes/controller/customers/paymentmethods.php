<?php

namespace Api;

/**
 * Customer payment methods Controller.
 * 
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Customers_Paymentmethods extends Controller
{
	/**
	 * Gets one or more payment methods.
	 *
	 * @param int $customer_id Customer ID.
	 * @param int $id          Payment method ID.
	 *
	 * @return void
	 */
	public function get_index($customer_id = null, $id = null)
	{
		$customer = $this->get_customer($customer_id);
		
		if (!$id) {
			$payment_methods = \Service_Customer_Paymentmethod::find(array(
				'customer' => $customer,
			));
		} else {
			$payment_methods = $this->get_paymentmethod($id, $customer);
		}
		
		$this->response($payment_methods);
	}
	
	/**
	 * Creates a payment method.
	 *
	 * @param int $customer_id Customer ID.
	 *
	 * @return void
	 */
	public function post_index($customer_id = null)
	{
		$customer = $this->get_customer($customer_id);
		
		$gateway_args = array('seller' => \Seller::active());
		if ($seller_gateway_id = \Input::post('seller_gateway_id')) {
			$gateway_args['id'] = $seller_gateway_id;
		}
		
		$gateway = \Service_Gateway::find_one($gateway_args);
		
		$validator = \Validation_Customer_Paymentmethod::create($gateway);
		if (!$validator->run()) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$payment_method = \Service_Customer_Paymentmethod::create($customer, $gateway, $data);
		if (!$payment_method) {
			throw new HttpServerErrorException;
		}
		
		$this->response($payment_method);
	}
	
	/**
	 * Updates a payment method.
	 *
	 * @param int $customer_id Customer ID.
	 * @param int $id          Payment method ID.
	 *
	 * @return void
	 */
	public function put_index($customer_id = null, $id = null)
	{
		$customer       = $this->get_customer($customer_id);
		$payment_method = $this->get_paymentmethod($id, $customer);
		
		$validator = \Validation_Customer_Paymentmethod::update($payment_method->gateway);
		if (!$validator->run(\Input::put())) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$payment_method = \Service_Customer_Paymentmethod::update($payment_method, $data);
		if (!$payment_method) {
			throw new HttpServerErrorException;
		}
		
		$this->response($payment_method);
	}
	
	/**
	 * Deletes a payment method.
	 *
	 * @param int $customer_id Customer ID.
	 * @param int $id          Payment method ID.
	 *
	 * @return void
	 */
	public function delete_index($customer_id = null, $id = null)
	{
		$customer       = $this->get_customer($customer_id);
		$payment_method = $this->get_paymentmethod($id, $customer);
		
		$deleted = \Service_Customer_Paymentmethod::delete($payment_method);
		if (!$deleted) {
			throw new HttpServerErrorException;
		}
	}
	
	/**
	 * Attempts to get a customer from a given ID.
	 *
	 * @param int $id Customer ID.
	 *
	 * @return \Model_Customer
	 */
	protected function get_customer($id)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$customer = \Service_Customer::find_one($id);
		if (!$customer || $customer->seller != \Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $customer;
	}
	
	/**
	 * Attempts to get a payment method from a given ID.
	 *
	 * @param int             $id       Payment method ID.
	 * @param \Model_Customer $customer Customer the payment method should belong to.
	 *
	 * @return \Model_Customer_Paymentmethod
	 */
	protected function get_paymentmethod($id, \Model_Customer $customer)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$payment_method = \Service_Customer_Paymentmethod::find_one($id);
		if (!$payment_method || $payment_method->customer != $customer || $payment_method->customer->seller != \Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $payment_method;
	}
}
