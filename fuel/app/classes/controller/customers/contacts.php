<?php

/**
 * The customer contacts controller.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Customers_Contacts extends Controller_Customers
{
	/**
	 * Displays a customer's contacts.
	 *
	 * @param int $customer_id Customer ID.
	 *
	 * @return void
	 */
	public function action_index($customer_id = null)
	{
		$customer = $this->get_customer($customer_id);
		
		$this->view->customer = $customer;
		$this->view->contacts = $customer->contacts;
		$this->view->primary  = Service_Contact::primary($customer);
	}
}
