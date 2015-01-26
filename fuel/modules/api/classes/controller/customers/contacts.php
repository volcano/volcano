<?php

namespace Api;

/**
 * Customer contacts controller.
 */
class Controller_Customers_Contacts extends Controller
{
	/**
	 * Gets one or more contacts.
	 *
	 * @param int $customer_id Customer ID.
	 * @param int $id          Contact ID.
	 *
	 * @return void
	 */
	public function get_index($customer_id = null, $id = null)
	{
		$customer = $this->get_customer($customer_id);
		
		if (!$id) {
			$contacts = $customer->contacts;
		} else {
			$contacts = $this->get_contact($id, $customer);
		}
		
		$this->response($contacts);
	}
	
	/**
	 * Creates a contact.
	 *
	 * @param int $customer_id Customer ID.
	 *
	 * @return void
	 */
	public function post_index($customer_id = null)
	{
		$customer = $this->get_customer($customer_id);
		
		$validator = \Validation_Contact::create();
		if (!$validator->run()) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$contact = \Service_Contact::create($data);
		if (!$contact) {
			throw new HttpServerErrorException;
		}
		
		if (!\Service_Contact::link($contact, $customer, \Arr::get($data, 'primary', false))) {
			throw new HttpServerErrorException;
		}
		
		$this->response($contact);
	}
	
	/**
	 * Updates a contact.
	 *
	 * @param int $customer_id Customer ID.
	 * @param int $id          Contact ID.
	 *
	 * @return void
	 */
	public function put_index($customer_id = null, $id = null)
	{
		$customer = $this->get_customer($customer_id);
		$contact  = $this->get_contact($id, $customer);
		
		$validator = \Validation_Contact::update();
		if (!$validator->run(\Input::put())) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$contact = \Service_Contact::update($contact, $data);
		if (!$contact) {
			throw new HttpServerErrorException;
		}
		
		$this->response($contact);
	}
	
	/**
	 * Deletes a contact.
	 *
	 * @param int $customer_id Customer ID.
	 * @param int $id          Contact ID.
	 *
	 * @return void
	 */
	public function delete_index($customer_id = null, $id = null)
	{
		$customer = $this->get_customer($customer_id);
		$contact  = $this->get_contact($id, $customer);
		
		$deleted = \Service_Contact::unlink($contact, $customer);
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
	
	/**
	 * Attempts to get a contact from a given ID.
	 *
	 * @param int             $id       Contact ID.
	 * @param \Model_Customer $customer Customer the contact should belong to.
	 *
	 * @return \Model_Contact
	 */
	protected function get_contact($id, \Model_Customer $customer)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$contact = \Service_Contact::find_one($id);
		if (!$contact || !\Arr::key_exists($customer->contacts, $contact->id)) {
			throw new HttpNotFoundException;
		}
		
		return $contact;
	}
}
