<?php

namespace Api;

/**
 * Products controller.
 */
class Controller_Products extends Controller
{
	/**
	 * Gets one or more products.
	 *
	 * @param int $id Product ID.
	 *
	 * @return void
	 */
	public function get_index($id = null)
	{
		$seller = \Seller::active();
		
		if (!$id) {
			$products = \Service_Product::find(array(
				'seller' => $seller,
			));
		} else {
			$products = \Service_Product::find_one($id);
			if (!$products || $products->seller != $seller) {
				throw new HttpNotFoundException;
			}
		}
		
		$this->response($products);
	}
	
	/**
	 * Creates a product.
	 *
	 * @return void
	 */
	public function post_index()
	{
		$validator = \Validation_Product::create();
		if (!$validator->run()) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$product = \Service_Product::create($data['name'], \Seller::active(), $data);
		if (!$product) {
			throw new HttpServerErrorException;
		}
		
		$this->response($product);
	}
	
	/**
	 * Updates a product.
	 *
	 * @param int $id Product ID.
	 *
	 * @return void
	 */
	public function put_index($id = null)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$product = \Service_Product::find_one($id);
		if (!$product || $product->seller != \Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		$validator = \Validation_Product::update();
		if (!$validator->run(\Input::put())) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$product = \Service_Product::update($product, $data);
		if (!$product) {
			throw new HttpServerErrorException;
		}
		
		$this->response($product);
	}
	
	/**
	 * Deletes a product.
	 *
	 * @param int $id Product ID.
	 *
	 * @return void
	 */
	public function delete_index($id = null)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$product = \Service_Product::find_one($id, \Seller::active());
		if (!$product || $product->seller != \Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		$deleted = \Service_Product::delete($product);
		if (!$deleted) {
			throw new HttpServerErrorException;
		}
	}
}
