<?php

namespace Api;

/**
 * Product options controller.
 */
class Controller_Products_Options extends Controller
{
	/**
	 * Gets one or more product options.
	 *
	 * @param int $product_id Product ID.
	 * @param int $id         Product option ID.
	 *
	 * @return void
	 */
	public function get_index($product_id = null, $id = null)
	{
		$product = $this->get_product($product_id);
		
		if (!$id) {
			$options = \Service_Product_Option::find(array(
				'product' => $product,
			));
		} else {
			$options = $this->get_option($id, $product);
		}
		
		$this->response($options);
	}
	
	/**
	 * Creates a product option.
	 *
	 * @param int $product_id Product ID.
	 *
	 * @return void
	 */
	public function post_index($product_id = null)
	{
		$product = $this->get_product($product_id);
		
		$validator = \Validation_Product_Option::create();
		if (!$validator->run()) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$option = \Service_Product_Option::create($data['name'], $product, $data);
		if (!$option) {
			throw new HttpServerErrorException;
		}
		
		$this->response($option);
	}
	
	/**
	 * Updates a product option.
	 *
	 * @param int $product_id Product ID.
	 * @param int $id         Product option ID.
	 *
	 * @return void
	 */
	public function put_index($product_id = null, $id = null)
	{
		$product = $this->get_product($product_id);
		$option  = $this->get_option($id, $product);
		
		$validator = \Validation_Product_Option::update();
		if (!$validator->run(\Input::put())) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$option = \Service_Product_Option::update($option, $data);
		if (!$option) {
			throw new HttpServerErrorException;
		}
		
		$this->response($option);
	}
	
	/**
	 * Deletes a product option.
	 *
	 * @param int $product_id Product ID.
	 * @param int $id         Product option ID.
	 *
	 * @return void
	 */
	public function delete_index($product_id = null, $id = null)
	{
		$product = $this->get_product($product_id);
		$option  = $this->get_option($id, $product);
		
		$deleted = \Service_Product_Option::delete($option);
		if (!$deleted) {
			throw new HttpServerErrorException;
		}
	}
	
	/**
	 * Attempts to get a product from a given ID.
	 *
	 * @param int $id Product ID.
	 *
	 * @return \Model_Product
	 */
	protected function get_product($id)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$product = \Service_Product::find_one($id);
		if (!$product || $product->seller != \Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $product;
	}
	
	/**
	 * Attempts to get a product option from a given ID.
	 *
	 * @param int            $id      Product Option ID.
	 * @param \Model_Product $product Product the option should belong to.
	 *
	 * @return \Model_Product_Option
	 */
	protected function get_option($id, \Model_Product $product)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$option = \Service_Product_Option::find_one($id);
		if (!$option || $option->product != $product || $option->product->seller != \Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $option;
	}
}
