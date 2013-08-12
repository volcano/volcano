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
}
