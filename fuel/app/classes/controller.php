<?php

/**
 * Base controller class.
 *
 * @author Mark Manos <mmanos@static.com>
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller extends \Fuel\Core\Controller
{
	/**
	 * Whether to auto render the view or not.
	 * 
	 * @var bool
	 */
	public $autorender = true;
	
	/**
	 * View instance used by the current controller/action.
	 *
	 * @var View
	 */
	public $view;
	
	/**
	 * The current Response object.
	 *
	 * @var Response
	 */
	public $response;
	
	/**
	 * This method gets called before the action is called.
	 *
	 * @return void
	 */
	public function before()
	{
		parent::before();
		
		if (!$this->response) {
			$this->response = Response::forge();
		}
		
		$this->view = View::forge();
	}
	
	/**
	 * This method gets called after the action is called.
	 *
	 * @param mixed $response Value returned from the action method.
	 * 
	 * @return Response $response
	 */
	public function after($response)
	{
		// Return if passed a response.
		if ($response instanceof Response) {
			return parent::after($response);
		}
		
		if ($this->autorender) {
			try {
				$this->view->set_filename(Str::lower(
					str_replace('_', '/', Inflector::denamespace(str_replace('controller_', '', Str::lower($this->request->controller))))
					. DS
					. str_replace('_', '/', $this->request->action)
				));
			} catch (FuelException $e) {}
		}
		
		$this->response->body($this->view);
		
		return parent::after($this->response);
	}
}
