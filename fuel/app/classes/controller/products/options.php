<?php

/**
 * The product options controller.
 */
class Controller_Products_Options extends Controller_Products
{
	/**
	 * Displays a product's options.
	 * 
	 * @param int $product_id Product ID.
	 *
	 * @return void
	 */
	public function action_index($product_id = null)
	{
		$product = $this->get_product($product_id);
		
		$options = Service_Product_Option::find(array(
			'product' => $product,
		));
		
		$this->view->product = $product;
		$this->view->options = $options;
	}
	
	/**
	 * GET Create action.
	 *
	 * @param int $product_id Product ID the new option should belong to.
	 *
	 * @return void
	 */
	public function get_create($product_id = null)
	{
		$this->view->product = $this->get_product($product_id);
	}
	
	/**
	 * POST Create action.
	 *
	 * @param int $product_id Product ID the new option should belong to.
	 *
	 * @return void
	 */
	public function post_create($product_id = null)
	{
		$this->get_create($product_id);
		
		$validator = Validation_Product_Option::create();
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$product = $this->get_product($product_id);
		$data    = $validator->validated();
		
		if (!Service_Product_Option::create($data['name'], $product, $data)) {
			Session::set_alert('error', 'There was an error adding the product option.');
			return;
		}
		
		Session::set_alert('success', 'The product option has been added.');
		Response::redirect($product->link('options'));
	}
	
	/**
	 * GET Edit action.
	 *
	 * @param int $product_id Product ID.
	 * @param int $id         Product option ID.
	 *
	 * @return void
	 */
	public function get_edit($product_id = null, $id = null)
	{
		$this->view->product = $this->get_product($product_id);
		$this->view->option  = $this->get_option($id);
	}
	
	/**
	 * POST Edit action.
	 *
	 * @param int $product_id Product ID.
	 * @param int $id         Product option ID.
	 *
	 * @return void
	 */
	public function post_edit($product_id = null, $id = null)
	{
		$this->get_edit($product_id, $id);
		
		$validator = Validation_Product_Option::update();
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$product = $this->get_product($product_id);
		$option  = $this->get_option($id);
		$data    = $validator->validated();
		
		if (!Service_Product_Option::update($option, $data)) {
			Session::set_alert('error', 'There was an error updating the product option.');
			return;
		}
		
		Session::set_alert('success', 'The product option has been updated.');
		Response::redirect($option->link('edit'));
	}
	
	/**
	 * Attempts to get a product option from a given ID.
	 *
	 * @param int $id Product option ID.
	 *
	 * @return Model_Product_Option
	 */
	protected function get_option($id)
	{
		$option = Service_Product_Option::find_one($id);
		if (!$option || $option->product->seller != Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $option;
	}
}
