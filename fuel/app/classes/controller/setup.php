<?php

/**
 * The setup controller.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Setup extends Controller
{
	/**
	 * This controller's layout.
	 *
	 * @var string
	 */
	public $layout = 'setup';
	
	/**
	 * GET Index action.
	 *
	 * @return void
	 */
	public function get_index() {}
	
	/**
	 * POST Index action.
	 *
	 * @return void
	 */
	public function post_index()
	{
		$this->get_index();
		
		$validator = Validation_Seller::create();
		if (!$validator->run()) {
			Session::set_alert('error', __('form.error'));
			$this->view->errors = $validator->error();
			return;
		}
		
		$data = $validator->validated();
		
		if (!$seller = Service_Seller::create($data['name'], $data)) {
			Session::set_alert('error', 'There was an error adding the seller.');
			return;
		}
		
		Response::redirect($seller->link('switch'));
	}
}
