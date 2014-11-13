<?php

/**
 * The product metas controller.
 */
class Controller_Products_Metas extends Controller_Products
{
	/**
	 * Displays a product's metas.
	 * 
	 * @param int $product_id Product ID.
	 *
	 * @return void
	 */
	public function action_index($product_id = null)
	{
		$product = $this->get_product($product_id);
		
		$metas = Service_Product_Meta::find(array(
			'product' => $product,
		));
		
		$this->view->product = $product;
		$this->view->metas   = $metas;
	}
	
	/**
	 * GET Create action.
	 *
	 * @param int $product_id Product ID the new meta should belong to.
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
	 * @param int $product_id Product ID the new meta should belong to.
	 *
	 * @return void
	 */
	public function post_create($product_id = null)
	{
		$this->get_create($product_id);
		
		$validator = Validation_Product_Meta::create();
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$product = $this->get_product($product_id);
		$data    = $validator->validated();
		
		if (!$meta = Service_Product_Meta::create($data['name'], $product)) {
			Session::set_alert('error', 'There was an error adding the product meta.');
			return;
		}
		
		foreach (array_filter($data['option']) as $value) {
			Service_Product_Meta_Option::create($value, $meta);
		}
		
		Session::set_alert('success', 'The product meta has been added.');
		Response::redirect($product->link('metas'));
	}
	
	/**
	 * GET Edit action.
	 *
	 * @param int $product_id Product ID.
	 * @param int $id         Product meta ID.
	 *
	 * @return void
	 */
	public function get_edit($product_id = null, $id = null)
	{
		$this->view->product = $this->get_product($product_id);
		$this->view->meta    = $this->get_meta($id);
	}
	
	/**
	 * POST Edit action.
	 *
	 * @param int $product_id Product ID.
	 * @param int $id         Product meta ID.
	 *
	 * @return void
	 */
	public function post_edit($product_id = null, $id = null)
	{
		$this->get_edit($product_id, $id);
		
		$validator = Validation_Product_Meta::update();
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$product = $this->get_product($product_id);
		$meta    = $this->get_meta($id);
		$data    = $validator->validated();
		
		if (!Service_Product_Meta::update($meta, $data)) {
			Session::set_alert('error', 'There was an error updating the product meta.');
			return;
		}
		
		$options = $meta->options;
		foreach (array_filter($data['option']) as $option_id => $value) {
			if ($option = Arr::get($options, $option_id)) {
				// Update existing meta option.
				Service_Product_Meta_Option::update($option, array('value' => $value));
			} else {
				// Create new meta option.
				Service_Product_Meta_Option::create($value, $meta);
			}
		}
		
		Session::set_alert('success', 'The product meta has been updated.');
		Response::redirect($product->link('metas'));
	}
	
	/**
	 * Attempts to get a product meta from a given ID.
	 *
	 * @param int $id Product meta ID.
	 *
	 * @return Model_Product_Meta
	 */
	protected function get_meta($id)
	{
		$meta = Service_Product_Meta::find_one($id);
		if (!$meta || $meta->product->seller != Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $meta;
	}
}
