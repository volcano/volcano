<?php

namespace Api;

/**
 * Customer transactions Controller.
 * 
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Customers_Transactions extends Controller
{
	/**
	 * Gets one or more customer transactions.
	 *
	 * @param int $customer_id Customer ID.
	 * @param int $id          Transaction ID.
	 *
	 * @return void
	 */
	public function get_index($customer_id = null, $id = null)
	{
		if (!$customer_id) {
			throw new HttpNotFoundException;
		}
		
		$customer = \Service_Customer::find_one($customer_id);
		if (!$customer || $customer->seller != \Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		if (!$id) {
			$transactions = \Service_Customer_Transaction::find(array(
				'customer' => $customer,
			));
		} else {
			$transactions = \Service_Customer_Transaction::find_one($id);
			if (!$transactions || $transactions->customer != $customer) {
				throw new HttpNotFoundException;
			}
		}
		
		$this->response($transactions);
	}
}
