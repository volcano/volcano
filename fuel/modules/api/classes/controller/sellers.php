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
	 * Gets a seller (find() not allowed for this API).
	 *
	 * @param int $id Seller ID.
	 *
	 * @return void
	 */
	public function get_index($id = null)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$seller = \Service_Seller::find_one($id);
		if (!$seller || $seller != \Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		$this->response($seller);
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
		
		$seller = \Service_Seller::create($data['name'], $data);
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
		if (!$seller || $seller != \Seller::active()) {
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
}
