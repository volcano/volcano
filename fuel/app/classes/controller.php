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
	 * Name of layout view template to use for the current controller/action.
	 * Set to null|false if no layout is needed.
	 *
	 * @var string
	 */
	public $layout = 'default';
	
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
		
		if (!empty($this->layout)) {
			$this->layout = View::forge('layouts' . DS . $this->layout);
			
			$this->view->layout = $this->layout;
			
			$this->layout->module      = $this->request->module;
			$this->layout->controller  = $this->request->controller;
			$this->layout->action      = $this->request->action;
			$this->layout->title       = null;
			$this->layout->breadcrumbs = array();
			$this->layout->content     = '';
		}
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
		
		// Inject view into the layout if the main request.
		if ($this->layout instanceof View) {
			if ($this->autorender) {
				try {
					// Throws exception if there is no view template found.
					$this->layout->content = $this->view->render();
				} catch (FuelException $e) {}
			}
			
			$this->layout->content_data = $this->view->get();
			
			$this->response->body($this->layout);
		}
		else {
			$this->response->body($this->view);
		}
		
		return parent::after($this->response);
	}
}
