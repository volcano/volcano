<?php

namespace Api;

/**
 * Gateways Controller.
 * 
 * @author Keithia Stegmann <kstegmann@static.com>
 */
class Controller_Gateways extends Controller
{
	/**
	 * Gets one or more gateways.
	 *
	 * @param int $id Gateway ID.
	 *
	 * @return void
	 */
	public function get_index($id = null)
	{
		if (!$id) {
			$gateways = \Service_Gateway::find();
		} else {
			$gateways = \Service_Gateway::find_one($id);
			if (!$gateways) {
				throw new HttpNotFoundException;
			}
		}
		
		$this->response($gateways);
	}
	
	/**
	 * Creates a gateway.
	 *
	 * @return void
	 */
	public function post_index()
	{
		$validator = \Validation_Gateway::create();
		if (!$validator->run()) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$gateway = \Service_Gateway::create($data['type'], $data['processor'], $data);
		if (!$gateway) {
			throw new HttpServerErrorException;
		}
		
		$this->response($gateway);
	}
	
	/**
	 * Updates a gateway.
	 *
	 * @param int $id Gateway ID.
	 *
	 * @return void
	 */
	public function put_index($id = null)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$gateway = \Service_Gateway::find_one($id);
		if (!$gateway) {
			throw new HttpNotFoundException;
		}
		
		$validator = \Validation_Gateway::update();
		if (!$validator->run(\Input::put())) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$gateway = \Service_Gateway::update($gateway, $data);
		if (!$gateway) {
			throw new HttpServerErrorException;
		}
		
		$this->response($gateway);
	}
	
	/**
	 * Deletes a gateway.
	 *
	 * @param int $id Gateway ID.
	 *
	 * @return void
	 */
	public function delete_index($id = null)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$gateway = \Service_Gateway::find_one($id);
		if (!$gateway) {
			throw new HttpNotFoundException;
		}
		
		$deleted = \Service_Gateway::delete($gateway);
		if (!$deleted) {
			throw new HttpServerErrorException;
		}
	}
}
