<?php

/**
 * The customer products controller.
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
	
	/**
	 * Cancels a customer product option.
	 *
	 * @param int $customer_id Customer ID.
	 * @param int $id          Customer product option to cancel.
	 *
	 * @return void
	 */
	public function action_cancel($customer_id = null, $id = null)
	{
		$this->update($customer_id, $id, array('status' => 'canceled'));
	}
	
	/**
	 * Activates a customer product option.
	 *
	 * @param int $customer_id Customer ID.
	 * @param int $id          Customer product option to cancel.
	 *
	 * @return void
	 */
	public function action_activate($customer_id = null, $id = null)
	{
		$this->update($customer_id, $id, array('status' => 'active'));
	}
	
	/**
	 * Updates a customer product option.
	 *
	 * @param int   $customer_id Customer ID.
	 * @param int   $id          Customer product option to cancel.
	 * @param array $data        Data to update.
	 *
	 * @return void
	 */
	protected function update($customer_id, $id, array $data)
	{
		$customer = $this->get_customer($customer_id);
		$option   = $this->get_option($id);
		
		if (!Service_Customer_Product_Option::update($option, $data)) {
			Session::set_alert('error', 'There was an error updating the customer product.');
		} else {
			Session::set_alert('success', 'The customer product has been updated.');
		}
		
		Response::redirect($customer->link('products'));
	}
	
	/**
	 * Attempts to get a customer product option from a given ID.
	 *
	 * @param int $id Customer product option ID.
	 *
	 * @return Model_Customer_Product_Option
	 */
	protected function get_option($id)
	{
		$option = Service_Customer_Product_Option::find_one(array('id' => $id, 'status' => 'all'));
		if (!$option || $option->customer->seller != Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $option;
	}
}
