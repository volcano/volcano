<?php

/**
 * The settings controller.
 */
class Controller_Settings extends Controller
{
	/**
	 * GET Index action.
	 *
	 * @return void
	 */
	public function get_index()
	{
		$this->view->seller = Seller::active();
	}
	
	/**
	 * POST Index action.
	 *
	 * @return void
	 */
	public function post_index()
	{
		$this->get_index();
		
		$validator = Validation_Seller::update();
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$data = $validator->validated();
		
		if (!Service_Seller::update(Seller::active(), $data)) {
			Session::set_alert('error', 'There was an error updating the seller.');
			return;
		}
		
		Session::set_alert('success', 'The seller has been updated.');
	}
	
	/**
	 * Switches the active seller.
	 * 
	 * @param int $id Seller ID.
	 *
	 * @return void
	 */
	public function action_switch($id = null)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$seller = Service_Seller::find_one($id);
		if (!$seller) {
			throw new HttpNotFoundException;
		}
		
		Seller::set($seller);
		
		Session::set_alert('success', "You are now viewing as seller \"{$seller->name}\".");
		Response::redirect('/');
	}
}
