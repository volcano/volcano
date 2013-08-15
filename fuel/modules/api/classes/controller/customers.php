<?php

namespace Api;

/**
 * Customers Controller.
 * 
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Customers extends Controller
{
	/**
	 * Gets one or more customers.
	 *
	 * @param int $id Customer ID.
	 *
	 * @return void
	 */
	public function get_index($id = null)
	{
		$seller = \Seller::active();
		
		if (!$id) {
			$customers = \Service_Customer::find(array(
				'seller' => $seller,
			));
		} else {
			$customers = $this->get_customer($id);
		}
		
		$this->response($customers);
	}
	
	/**
	 * Creates a customer.
	 *
	 * @return void
	 */
	public function post_index()
	{
		$validator = \Validation_Customer::create();
		if (!$validator->run()) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$customer = \Service_Customer::create(\Seller::active(), $data);
		if (!$customer) {
			throw new HttpServerErrorException;
		}
		
		$this->response($customer);
	}
	
	/**
	 * Updates a customer.
	 *
	 * @param int $id Customer ID.
	 *
	 * @return void
	 */
	public function put_index($id = null)
	{
		$customer = $this->get_customer($id);
		
		$validator = \Validation_Customer::update();
		if (!$validator->run(\Input::put())) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$customer = \Service_Customer::update($customer, $data);
		if (!$customer) {
			throw new HttpServerErrorException;
		}
		
		$this->response($customer);
	}
	
	/**
	 * Deletes a customer.
	 *
	 * @param int $id Customer ID.
	 *
	 * @return void
	 */
	public function delete_index($id = null)
	{
		$customer = $this->get_customer($id);
		
		$deleted = \Service_Customer::delete($customer);
		if (!$deleted) {
			throw new HttpServerErrorException;
		}
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
