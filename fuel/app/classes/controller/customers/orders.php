<?php

/**
 * The customer orders controller.
 */
class Controller_Customers_Orders extends Controller_Customers
{
	/**
	 * Displays a customer's orders.
	 *
	 * @param int $customer_id Customer ID.
	 *
	 * @return void
	 */
	public function action_index($customer_id = null)
	{
		$customer = $this->get_customer($customer_id);
		
		$this->view->customer = $customer;
		$this->view->orders = Service_Customer_Order::find(array('customer' => $customer));
	}
}
