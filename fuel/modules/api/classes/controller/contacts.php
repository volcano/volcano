<?php

namespace Api;

/**
 * Contacts Controller.
 * 
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Contacts extends Controller
{
	/**
	 * Gets one or more contacts.
	 *
	 * @param int $id Contact ID.
	 *
	 * @return void
	 */
	public function get_index($id = null)
	{
		if (!$id) {
			$contacts = \Service_Contact::find();
		} else {
			$contacts = \Service_Contact::find_one($id);
			if (!$contacts) {
				$this->error('invalid');
				return;
			}
		}
		
		$this->response($contacts);
	}
	
	/**
	 * Creates a contact.
	 *
	 * @return void
	 */
	public function post_index()
	{
		$validator = \Validation_Contact::create();
		if (!$validator->run()) {
			$this->error($validator->error());
			return;
		}
		
		$data = $validator->validated();
		
		$contact = \Service_Contact::create($data['first_name'], $data['last_name'], $data);
		if (!$contact) {
			$this->error('create');
			return;
		}
		
		$this->response($contact);
	}
	
	/**
	 * Updates a contact.
	 *
	 * @param int $id Contact ID.
	 *
	 * @return void
	 */
	public function put_index($id = null)
	{
		if (!$id) {
			$this->error(array('id'));
			return;
		}
		
		$contact = \Service_Contact::find_one($id);
		if (!$contact) {
			$this->error('invalid');
			return;
		}
		
		$validator = \Validation_Contact::update();
		if (!$validator->run(\Input::put())) {
			$this->error($validator->error());
			return;
		}
		
		$data = $validator->validated();
		
		$contact = \Service_Contact::update($contact, $data);
		if (!$contact) {
			$this->error('update');
			return;
		}
		
		$this->response($contact);
	}
	
	/**
	 * Deletes a contact.
	 *
	 * @param int $id Contact ID.
	 *
	 * @return void
	 */
	public function delete_index($id = null)
	{
		if (!$id) {
			$this->error(array('id'));
			return;
		}
		
		$contact = \Service_Contact::find_one($id);
		if (!$contact) {
			$this->error('invalid');
			return;
		}
		
		$deleted = \Service_Contact::delete($contact);
		if (!$deleted) {
			$this->error('delete');
			return;
		}
	}
}
