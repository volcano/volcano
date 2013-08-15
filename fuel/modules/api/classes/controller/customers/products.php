<?php

namespace Api;

/**
 * Customer products Controller.
 * 
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Customers_Products extends Controller
{
	/**
	 * Gets one or more customer product options.
	 *
	 * @param int $customer_id Customer ID.
	 * @param int $id          Product option ID.
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
			$products = \Service_Customer_Product_Option::find(array(
				'customer' => $customer,
			));
		} else {
			$products = \Service_Customer_Product_Option::find_one($id);
			if (!$products || $products->customer != $customer) {
				throw new HttpNotFoundException;
			}
		}
		
		$this->response($products);
	}
}
