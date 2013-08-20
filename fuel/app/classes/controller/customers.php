<?php

/**
 * The customers controller.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Customers extends Controller
{
	/**
	 * Displays a list of customers.
	 *
	 * @return void
	 */
	public function action_index()
	{
		$customers = Service_Customer::find(array(
			'seller' => Seller::active(),
			'status' => 'all',
		));
		
		$this->view->customers = $customers;
	}
	
	/**
	 * Attempts to get a customer from a given ID.
	 *
	 * @param int $id Customer ID.
	 *
	 * @return Model_Customer
	 */
	protected function get_customer($id)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$customer = Service_Customer::find_one(array('id' => $id, 'status' => 'all'));
		if (!$customer || $customer->seller != Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $customer;
	}
}
