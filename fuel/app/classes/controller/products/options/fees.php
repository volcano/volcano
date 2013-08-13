<?php

/**
 * The product option fees controller.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Products_Options_Fees extends Controller_Products_Options
{
	/**
	 * Displays a product option's fees.
	 * 
	 * @param int $option_id Product option ID.
	 *
	 * @return void
	 */
	public function action_index($option_id = null)
	{
		$option = $this->get_option($option_id);
		
		$fees = Service_Product_Option_Fee::find(array(
			'option' => $option,
		));
		
		$this->view->product = $option->product;
		$this->view->option  = $option;
		$this->view->fees    = $fees;
	}
	
	/**
	 * GET Create action.
	 *
	 * @param int $option_id Product option ID the new fee should belong to.
	 *
	 * @return void
	 */
	public function get_create($option_id = null)
	{
		$option = $this->get_option($option_id);
		
		$this->view->product = $option->product;
		$this->view->option  = $option;
	}
	
	/**
	 * POST Create action.
	 *
	 * @param int $option_id Product option ID the new fee should belong to.
	 *
	 * @return void
	 */
	public function post_create($option_id = null)
	{
		$this->get_create($option_id);
		
		$validator = Validation_Product_Option_Fee::create();
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$option = $this->get_option($option_id);
		$data   = $validator->validated();
		
		if (!Service_Product_Option_Fee::create($data['name'], $data['interval'], $data['interval_unit'], $data['interval_price'], $option, $data)) {
			Session::set_alert('error', 'There was an error creating your product option fee.');
			return;
		}
		
		Session::set_alert('success', 'Your product option fee has been created.');
		Response::redirect($option->link('fees'));
	}
	
	/**
	 * GET Edit action.
	 *
	 * @param int $option_id Product option ID.
	 * @param int $id        Product option fee ID.
	 *
	 * @return void
	 */
	public function get_edit($option_id = null, $id = null)
	{
		$option = $this->get_option($id);
		
		$this->view->product = $option->product;
		$this->view->option  = $option;
		$this->view->fee     = $this->get_fee($id);
	}
	
	/**
	 * POST Edit action.
	 *
	 * @param int $option_id Product option ID.
	 * @param int $id        Product option fee ID.
	 *
	 * @return void
	 */
	public function post_edit($option_id = null, $id = null)
	{
		$this->get_edit($option_id, $id);
		
		$validator = Validation_Product_Option_Fee::update();
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$option = $this->get_option($option_id);
		$fee    = $this->get_fee($id);
		$data   = $validator->validated();
		
		if (!Service_Product_Option_Fee::update($fee, $data)) {
			Session::set_alert('error', 'There was an error updating your product option fee.');
			return;
		}
		
		Session::set_alert('success', 'Your product option fee has been updated.');
		Response::redirect($option->link('fees'));
	}
	
	/**
	 * Attempts to get a product option fee from a given ID.
	 *
	 * @param int $id Product option fee ID.
	 *
	 * @return Model_Product_Option_Fee
	 */
	protected function get_fee($id)
	{
		$fee = Service_Product_Option_Fee::find_one($id);
		if (!$fee || $fee->option->product->seller != Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $fee;
	}
}
