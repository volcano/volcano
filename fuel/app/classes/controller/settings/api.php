<?php

/**
 * The seller API controller.
 */
class Controller_Settings_Api extends Controller
{
	/**
	 * Displays a seller's API keys.
	 *
	 * @return void
	 */
	public function action_index()
	{
		$keys = Service_Api_Key::find(array(
			'seller' => Seller::active(),
			'status' => 'all',
		));
		
		$this->view->keys = $keys;
	}
	
	/**
	 * Creates an API key for a seller.
	 *
	 * @return void
	 */
	public function action_create()
	{
		if (!Service_Api_Key::create(Seller::active())) {
			Session::set_alert('error', 'There was an error adding an API key.');
		} else {
			Session::set_alert('success', 'An API key has been added.');
		}
		
		Response::redirect('settings/api');
	}
	
	/**
	 * Deletes a seller API key.
	 *
	 * @param int $id API key.
	 *
	 * @return void
	 */
	public function action_delete($id = null)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$key = Service_Api_Key::find_one($id);
		if (!$key || $key->seller != Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		if (!Service_Api_Key::delete($key)) {
			Session::set_alert('error', 'There was an error removing the API key.');
		} else {
			Session::set_alert('success', 'The API key has been removed.');
		}
		
		Response::redirect('settings/api');
	}
}
