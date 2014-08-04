<?php

/**
 * The seller callbacks controller.
 */
class Controller_Settings_Callbacks extends Controller
{
	/**
	 * Displays a seller's callbacks.
	 *
	 * @return void
	 */
	public function action_index()
	{
		$this->view->callbacks = Service_Seller_Callback::find(array(
			'seller' => Seller::active(),
		));
	}
	
	/**
	 * GET Create action.
	 *
	 * @return void
	 */
	public function get_create()
	{
		$this->view->events = Service_Event::find();
	}
	
	/**
	 * POST Create action.
	 *
	 * @return void
	 */
	public function post_create()
	{
		$this->get_create();
		
		$validator = Validation_Seller_Callback::create();
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$data = $validator->validated();
		
		$event = \Service_Event::find_one(array('name' => $data['event']));
		
		if (Service_Seller_Callback::create(Seller::active(), $event, $data['url'])) {
			Session::set_alert('success', 'The event callback has been added.');
		} else {
			Session::set_alert('error', 'There was an error adding the event callback.');
		}
		
		Response::redirect('settings/callbacks');
	}
	
	/**
	 * GET Edit action.
	 *
	 * @param int $id Seller callback ID.
	 *
	 * @return void
	 */
	public function get_edit($id = null)
	{
		$this->view->callback  = $this->get_callback($id);
		$this->view->events = Service_Event::find();
	}
	
	/**
	 * POST Edit action.
	 *
	 * @param int $id Seller callback ID.
	 *
	 * @return void
	 */
	public function post_edit($id = null)
	{
		$this->get_edit($id);
		
		$validator = Validation_Seller_Callback::update();
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$data = $validator->validated();
		
		if (!Service_Seller_Callback::update($this->get_callback($id), $data)) {
			Session::set_alert('error', 'There was an error updating the event callback.');
		} else {
			Session::set_alert('success', 'The event callback has been updated.');
		}
		
		Response::redirect('settings/callbacks');
	}
	
	/**
	 * Deletes a seller callback.
	 *
	 * @param int $seller_id Seller ID.
	 * @param int $id        Seller callback ID.
	 *
	 * @return void
	 */
	public function action_delete($id = null)
	{
		$callback = $this->get_callback($id);
		
		if (!Service_Seller_Callback::delete($callback)) {
			Session::set_alert('error', 'There was an error deleting the event callback.');
		} else {
			Session::set_alert('success', 'The event callback has been deleted.');
		}
		
		Response::redirect(Seller::active()->link('callbacks'));
	}
	
	/**
	 * Attempts to get a seller callback from a given ID.
	 *
	 * @param int $id Seller callback ID.
	 *
	 * @return Model_Seller_Callback
	 */
	protected function get_callback($id)
	{
		$callback = Service_Seller_Callback::find_one(array(
			'id'     => $id,
			'seller' => Seller::active(),
		));
		
		if (!$callback) {
			throw new HttpNotFoundException;
		}
		
		return $callback;
	}
}
