<?php

/**
 * The products controller.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Products extends Controller
{
	/**
	 * Display's a seller's products.
	 *
	 * @return void
	 */
	public function action_index()
	{
		$products = Service_Product::find(array(
			'seller' => Seller::active(),
		));
		
		$this->view->products = $products;
	}
	
	/**
	 * GET Create action.
	 *
	 * @return void
	 */
	public function get_create() {}
	
	/**
	 * POST Create action.
	 *
	 * @return void
	 */
	public function post_create()
	{
		$this->get_create();
		
		$validator = Validation_Product::create();
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$data = $validator->validated();
		
		if (!Service_Product::create($data['name'], Seller::active(), $data)) {
			Session::set_alert('error', 'There was an error adding the product.');
			return;
		}
		
		Session::set_alert('success', 'The product has been added.');
		Response::redirect('products');
	}
	
	/**
	 * GET Edit action.
	 *
	 * @param int $id Product ID.
	 *
	 * @return void
	 */
	public function get_edit($id = null)
	{
		$this->view->product = $this->get_product($id);
	}
	
	/**
	 * POST Edit action.
	 *
	 * @param int $id Product ID.
	 *
	 * @return void
	 */
	public function post_edit($id = null)
	{
		$this->get_edit($id);
		
		$validator = Validation_Product::update();
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$product = $this->get_product($id);
		$data    = $validator->validated();
		
		if (!Service_Product::update($product, $data)) {
			Session::set_alert('error', 'There was an error updating the product.');
			return;
		}
		
		Session::set_alert('success', 'The product has been updated.');
		Response::redirect('products');
	}
	
	/**
	 * Attempts to get a product from a given ID.
	 *
	 * @param int $id Product ID.
	 *
	 * @return Model_Product
	 */
	protected function get_product($id)
	{
		$product = Service_Product::find_one($id);
		if (!$product || $product->seller != Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $product;
	}
}
