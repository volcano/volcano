<?php

namespace Api;

/**
 * Product Option Fees Controller.
 * 
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Products_Options_Fees extends Controller
{
	/**
	 * Gets one or more product option fees.
	 *
	 * @param int $option_id Product option ID.
	 * @param int $id        Product option fee ID.
	 *
	 * @return void
	 */
	public function get_index($option_id = null, $id = null)
	{
		$option = $this->get_option($option_id);
		
		if (!$id) {
			$fees = \Service_Product_Option_Fee::find(array(
				'option' => $option,
			));
		} else {
			$fees = $this->get_fee($id, $option);
		}
		
		$this->response($fees);
	}
	
	/**
	 * Creates a product option fee.
	 *
	 * @param int $option_id Product option ID.
	 *
	 * @return void
	 */
	public function post_index($option_id = null)
	{
		$option = $this->get_option($option_id);
		
		$validator = \Validation_Product_Option_Fee::create();
		if (!$validator->run()) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$fee = \Service_Product_Option_Fee::create(
			$data['interval'],
			$data['interval_unit'],
			$data['interval_price'],
			$option
		);
		
		if (!$fee) {
			throw new HttpServerErrorException;
		}
		
		$this->response($fee);
	}
	
	/**
	 * Updates a product option fee.
	 *
	 * @param int $option_id Product option ID.
	 * @param int $id        Product option fee ID.
	 *
	 * @return void
	 */
	public function put_index($option_id = null, $id = null)
	{
		$option = $this->get_option($option_id);
		$fee    = $this->get_fee($id, $option);
		
		$validator = \Validation_Product_Option_Fee::update();
		if (!$validator->run(\Input::put())) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$fee = \Service_Product_Option_Fee::update($fee, $data);
		if (!$fee) {
			throw new HttpServerErrorException;
		}
		
		$this->response($fee);
	}
	
	/**
	 * Deletes a product option fee.
	 *
	 * @param int $option_id Product option ID.
	 * @param int $id        Product option fee ID.
	 *
	 * @return void
	 */
	public function delete_index($option_id = null, $id = null)
	{
		$option = $this->get_option($option_id);
		$fee    = $this->get_fee($id, $option);
		
		$deleted = \Service_Product_Option_Fee::delete($fee);
		if (!$deleted) {
			throw new HttpServerErrorException;
		}
	}
	
	/**
	 * Attempts to get a product option from a given ID.
	 *
	 * @param int $id Product option ID.
	 *
	 * @return \Model_Product_Option
	 */
	protected function get_option($id)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$option = \Service_Product_Option::find_one($id);
		if (!$option || $option->product->seller != \Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $option;
	}
	
	/**
	 * Attempts to get a product option fee from a given ID.
	 *
	 * @param int                   $id     Product Option ID.
	 * @param \Model_Product_Option $option Product option the fee should belong to.
	 *
	 * @return \Model_Product_Option_Fee
	 */
	protected function get_fee($id, \Model_Product_Option $option)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$fee = \Service_Product_Option_Fee::find_one($id);
		if (!$fee || $fee->option != $option || $fee->option->product->seller != \Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $fee;
	}
}
