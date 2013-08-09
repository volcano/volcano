<?php

/**
 * The customer transactions controller.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Customers_Transactions extends Controller_Customers
{
	/**
	 * Displays a customer's transactions.
	 *
	 * @param int $customer_id Customer ID.
	 *
	 * @return void
	 */
	public function action_index($customer_id = null)
	{
		$customer = $this->get_customer($customer_id);
		
		$this->view->customer = $customer;
		$this->view->transactions = Service_Customer_Transaction::find(array('customer' => $customer));
	}
}
