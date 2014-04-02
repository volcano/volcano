<?php

/**
 * The customers controller.
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
		$args = array(
			'seller' => Seller::active(),
			'status' => 'all',
		);
		
		$pagination = Pagination::forge('customer_pagination', array(
			'total_items' => Service_Customer::count($args),
		));
		
		$customers = Service_Customer::find(array_merge($args, array(
			'offset' => $pagination->offset,
			'limit'  => $pagination->per_page,
		)));
		
		$this->view->customers = $customers;
		$this->view->pagination = $pagination;
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
