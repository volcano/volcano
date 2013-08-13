<?php

/**
 * The customer products controller.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Customers_Products extends Controller_Customers
{
	/**
	 * Displays a customer's products.
	 *
	 * @param int $customer_id Customer ID.
	 *
	 * @return void
	 */
	public function action_index($customer_id = null)
	{
		$customer = $this->get_customer($customer_id);
		
		$this->view->customer = $customer;
		$this->view->products = Service_Customer_Product_Option::find(array(
			'customer' => $customer,
			'status'   => 'all',
		));
	}
}
