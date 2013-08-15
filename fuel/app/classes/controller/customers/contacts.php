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
	
	/**
	 * GET Edit action.
	 *
	 * @param int $customer_id Customer ID.
	 * @param int $id          Contact ID.
	 *
	 * @return void
	 */
	public function get_edit($customer_id = null, $id = null)
	{
		$this->view->customer = $this->get_customer($customer_id);
		$this->view->contact  = $this->get_contact($customer_id, $id);
	}
	
	/**
	 * POST Edit action.
	 *
	 * @param int $customer_id Customer ID.
	 * @param int $id          Contact ID.
	 *
	 * @return void
	 */
	public function post_edit($customer_id = null, $id = null)
	{
		$this->get_edit($customer_id, $id);
		
		$validator = Validation_Contact::update();
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			dar($validator->error());die;
			$this->view->errors = $validator->error();
			return;
		}
		
		$customer = $this->get_customer($customer_id);
		$contact  = $this->get_contact($customer_id, $id);
		$data     = $validator->validated();
		
		if (!Service_Contact::update($contact, $data)) {
			Session::set_alert('error', 'There was an error updating the customer contact.');
			return;
		}
		
		Session::set_alert('success', 'The customer contact has been updated.');
		Response::redirect($customer->link('contacts'));
	}
	
	/**
	 * Attempts to get a contact from a given ID.
	 *
	 * @param int $id Contact ID.
	 *
	 * @return Model_Contact
	 */
	protected function get_contact($customer_id, $id)
	{
		$customer = $this->get_customer($customer_id);
		if ($customer->seller != Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		$contact = Service_Contact::find_one($id);
		if (!$contact || $contact != Service_Contact::primary($customer)) {
			throw new HttpNotFoundException;
		}
		
		return $contact;
	}
}
