<?php

/**
 * The customer payment methods controller.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Customers_Paymentmethods extends Controller_Customers
{
	/**
	 * Displays a customer's payment methods.
	 *
	 * @param int $customer_id Customer ID.
	 *
	 * @return void
	 */
	public function action_index($customer_id = null)
	{
		$customer = $this->get_customer($customer_id);
		
		$this->view->customer = $customer;
		$this->view->paymentmethods = Service_Customer_Paymentmethod::find(array(
			'customer' => $customer,
			'status'   => 'all',
		));
	}
	
	/**
	 * GET Create action.
	 *
	 * @param int $customer_id Customer ID.
	 *
	 * @return void
	 */
	public function get_create($customer_id = null)
	{
		$this->view->customer = $this->get_customer($customer_id);
		$this->view->gateway  = $this->get_gateway();
	}
	
	/**
	 * POST Create action.
	 *
	 * @param int $customer_id Customer ID.
	 *
	 * @return void
	 */
	public function post_create($customer_id = null)
	{
		$this->get_create($customer_id);
		
		$gateway  = $this->get_gateway();
		
		$validator = Validation_Customer_Paymentmethod::create($gateway);
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$data = $validator->validated();
		
		$customer = $this->get_customer($customer_id);
		
		if (!Service_Customer_Paymentmethod::create($customer, $gateway, $data)) {
			Session::set_alert('error', 'There was an error adding the customer payment method.');
			return;
		}
		
		Session::set_alert('success', 'The customer payment method has been added.');
		Response::redirect($customer->link('paymentmethods'));
	}
	
	/**
	 * GET Edit action.
	 *
	 * @param int $id Payment method ID.
	 *
	 * @return void
	 */
	public function get_edit($customer_id = null, $id = null)
	{
		$this->view->customer      = $this->get_customer($customer_id);
		$this->view->paymentmethod = $this->get_paymentmethod($id);
	}
	
	/**
	 * POST Edit action.
	 *
	 * @param int $id Payment method ID.
	 *
	 * @return void
	 */
	public function post_edit($customer_id = null, $id = null)
	{
		$this->get_edit($customer_id, $id);
		
		$validator = Validation_Customer_Paymentmethod::update($this->get_gateway());
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$customer      = $this->get_customer($customer_id);
		$paymentmethod = $this->get_paymentmethod($id);
		$data          = $validator->validated();
		
		if (!Service_Customer_Paymentmethod::update($paymentmethod, $data)) {
			Session::set_alert('error', 'There was an error updating the customer payment method.');
			return;
		}
		
		Session::set_alert('success', 'The customer payment method has been updated.');
		Response::redirect($customer->link('paymentmethods'));
	}
	
	/**
	 * Delete action.
	 *
	 * @param int $customer_id Customer ID.
	 * @param int $id          Payment method ID.
	 *
	 * @return void
	 */
	public function action_delete($customer_id = null, $id = null)
	{
		if (!Service_Customer_Paymentmethod::delete($this->get_paymentmethod($id))) {
			Session::set_alert('error', 'There was an error removing the customer payment method.');
		} else {
			Session::set_alert('success', 'The customer payment method has been removed.');
		}
		
		Response::redirect($this->get_customer($customer_id)->link('paymentmethods'));
	}
	
	/**
	 * Attempts to get a customer payment method from a given ID.
	 *
	 * @param int $id Payment method ID.
	 *
	 * @return Model_Customer_Paymentmethod
	 */
	protected function get_paymentmethod($id)
	{
		$paymentmethod = Service_Customer_Paymentmethod::find_one($id);
		if (!$paymentmethod || $paymentmethod->customer->seller != Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $paymentmethod;
	}
	
	/**
	 * Attempts to get a seller's primary gateway.
	 *
	 * @return Model_Gateway
	 */
	public function get_gateway()
	{
		$gateway = Service_Gateway::find_one(array(
			'seller' => Seller::active(),
		));
		
		if (!$gateway) {
			throw new HttpNotFoundException;
		}
		
		return $gateway;
	}
}
