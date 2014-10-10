<?php

namespace Api;

/**
 * Customer orders controller.
 */
class Controller_Customers_Orders extends Controller
{
	/**
	 * Gets one or more orders.
	 *
	 * @param int $customer_id Customer ID.
	 * @param int $id          Payment method ID.
	 *
	 * @return void
	 */
	public function get_index($customer_id = null, $id = null)
	{
		$customer = $this->get_customer($customer_id);
		
		if (!$id) {
			$orders = \Service_Customer_Order::find(array(
				'customer' => $customer,
			));
		} else {
			$orders = \Service_Customer_Order::find_one($id);
			if (!$orders || $orders->customer != $customer || $orders->customer->seller != \Seller::active()) {
				throw new HttpNotFoundException;
			}
		}
		
		$this->response($orders);
	}
	
	/**
	 * Creates an order.
	 *
	 * @param int $customer_id Customer ID.
	 *
	 * @return void
	 */
	public function post_index($customer_id = null)
	{
		$customer = $this->get_customer($customer_id);
		
		$validator = \Validation_Customer_Order::create($customer);
		if (!$validator->run()) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$order = \Service_Customer_Order::create($customer, $data['products'], $data['paymentmethod']);
		if (!$order) {
			throw new HttpServerErrorException;
		}
		
		$this->response($order);
	}
	
	/**
	 * Attempts to get a customer from a given ID.
	 *
	 * @param int $id Customer ID.
	 *
	 * @return \Model_Customer
	 */
	protected function get_customer($id)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$customer = \Service_Customer::find_one($id);
		if (!$customer || $customer->seller != \Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $customer;
	}
}
