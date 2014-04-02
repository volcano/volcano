<?php

namespace Api;

/**
 * Seller gateways controller.
 */
class Controller_Sellers_Gateways extends Controller
{
	/**
	 * Gets one or more gateways.
	 *
	 * @param int $seller_id Seller ID.
	 * @param int $id        Gateway ID.
	 *
	 * @return void
	 */
	public function get_index($seller_id = null, $id = null)
	{
		if (!$id) {
			$gateways = \Service_Gateway::find(array(
				'seller' => \Seller::active(),
			));
		} else {
			$gateways = $this->get_gateway($id);
		}
		
		$this->response($gateways);
	}
	
	/**
	 * Creates a gateway.
	 *
	 * @param int $seller_id Seller ID.
	 *
	 * @return void
	 */
	public function post_index($seller_id = null)
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
		
		if (!\Service_Gateway::link($gateway, \Seller::active())) {
			throw new HttpServerErrorException;
		}
		
		$this->response($gateway);
	}
	
	/**
	 * Updates a gateway.
	 *
	 * @param int $seller_id Seller ID.
	 * @param int $id        Gateway ID.
	 *
	 * @return void
	 */
	public function put_index($seller_id = null, $id = null)
	{
		$gateway = $this->get_gateway($id);
		
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
	 * @param int $seller_id Seller ID.
	 * @param int $id        Gateway ID.
	 *
	 * @return void
	 */
	public function delete_index($seller_id = null, $id = null)
	{
		$gateway = $this->get_gateway($id);
		
		if (!\Service_Gateway::unlink($gateway, \Seller::active())) {
			throw new HttpServerErrorException;
		}
		
		$deleted = \Service_Gateway::delete($gateway);
		if (!$deleted) {
			throw new HttpServerErrorException;
		}
	}
	
	/**
	 * Attempts to get a gateway from a given ID.
	 *
	 * @param int $id Gateway ID.
	 *
	 * @return \Model_Gateway
	 */
	protected function get_gateway($id)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$gateway = \Service_Gateway::find_one(array(
			'id'     => $id,
			'seller' => \Seller::active(),
		));
		
		if (!$gateway) {
			throw new HttpNotFoundException;
		}
		
		return $gateway;
	}
}
