<?php

/**
 * The seller gateways controller.
 */
class Controller_Settings_Gateways extends Controller
{
	/**
	 * Displays a seller's gateways.
	 *
	 * @return void
	 */
	public function action_index()
	{
		$this->view->gateways = Service_Gateway::find(array(
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
		Config::load('gateway', true);
		
		$this->view->config  = Config::get('gateway');
	}
	
	/**
	 * POST Create action.
	 *
	 * @return void
	 */
	public function post_create()
	{
		$this->get_create();
		
		$data = Input::post();
		$data['meta'] = array();
		
		foreach (Input::post('meta') as $meta) {
			if ($name = Arr::get($meta, 'name')) {
				$data['meta'][$name] = Arr::get($meta, 'value');
			}
		}
		
		$validator = Validation_Gateway::create();
		if (!$validator->run($data)) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$data = $validator->validated();
		
		if ($gateway = Service_Gateway::create($data['type'], $data['processor'], $data)) {
			if (Service_Gateway::link($gateway, Seller::active())) {
				Session::set_alert('success', 'The gateway has been added.');
			} else{
				Session::set_alert('error', 'There was an error adding the gateway.');
			}
		} else {
			Session::set_alert('error', 'There was an error adding the gateway.');
		}
		
		Response::redirect('settings/gateways');
	}
	
	/**
	 * GET Edit action.
	 *
	 * @param int $id Gateway ID.
	 *
	 * @return void
	 */
	public function get_edit($id = null)
	{
		Config::load('gateway', true);
		
		$this->view->gateway = $this->get_gateway($id);
		$this->view->config  = Config::get('gateway');
		$this->view->enc_key = Config::get('security.db_enc_key');
	}
	
	/**
	 * POST Edit action.
	 *
	 * @param int $id Gateway ID.
	 *
	 * @return void
	 */
	public function post_edit($id = null)
	{
		$this->get_edit($id);
		
		$validator = Validation_Gateway::update();
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$data = $validator->validated();
		
		if (!Service_Gateway::update($this->get_gateway($id), $data)) {
			Session::set_alert('error', 'There was an error updating the gateway.');
		} else {
			Session::set_alert('success', 'The gateway has been updated.');
		}
		
		Response::redirect('settings/gateways');
	}
	
	/**
	 * Attempts to get a gateway from a given ID.
	 *
	 * @param int $id Gateway ID.
	 *
	 * @return Model_Gateway
	 */
	protected function get_gateway($id)
	{
		$gateway = Service_Gateway::find_one(array(
			'id'     => $id,
			'seller' => Seller::active(),
		));
		
		if (!$gateway) {
			throw new HttpNotFoundException;
		}
		
		return $gateway;
	}
}
