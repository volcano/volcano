<?php

namespace Api;

/**
 * Sellers Controller.
 * 
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Sellers extends Controller
{
	/**
	 * Gets one or more sellers.
	 *
	 * @param int $id Seller ID.
	 *
	 * @return void
	 */
	public function get_index($id = null)
	{
		if (!$id) {
			$sellers = \Service_Seller::find();
		} else {
			$sellers = \Service_Seller::find_one($id);
			if (!$sellers) {
				throw new HttpNotFoundException;
			}
		}
		
		print_r($sellers::relations());die;
		
		$this->response($sellers);
	}
	
	/**
	 * Creates a seller.
	 *
	 * @return void
	 */
	public function post_index()
	{
		$validator = \Validation_Seller::create();
		if (!$validator->run()) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$contact = \Service_Contact::find_one(\Arr::get($data, 'contact_id'));
		if (!$contact) {
			throw new HttpBadRequestException('contact_id');
		}
		
		$seller = \Service_Seller::create($data['name'], $contact, $data);
		if (!$seller) {
			throw new HttpServerErrorException;
		}
		
		$this->response($seller);
	}
	
	/**
	 * Updates a seller.
	 *
	 * @param int $id Seller ID.
	 *
	 * @return void
	 */
	public function put_index($id = null)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$seller = \Service_Seller::find_one($id);
		if (!$seller) {
			throw new HttpNotFoundException;
		}
		
		$validator = \Validation_Seller::update();
		if (!$validator->run(\Input::put())) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$seller = \Service_Seller::update($seller, $data);
		if (!$seller) {
			throw new HttpServerErrorException;
		}
		
		$this->response($seller);
	}
	
	/**
	 * Deletes a seller.
	 *
	 * @param int $id Seller ID.
	 *
	 * @return void
	 */
	public function delete_index($id = null)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$seller = \Service_Seller::find_one($id);
		if (!$seller) {
			throw new HttpNotFoundException;
		}
		
		$deleted = \Service_Seller::delete($seller);
		if (!$deleted) {
			throw new HttpServerErrorException;
		}
	}
}
