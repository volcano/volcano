<?php

namespace Api;

use Config;

/**
 * Endpoints controller.
 */
class Controller_Endpoints extends Controller
{
	/**
	 * Gets the available API endpoints for the provided api key.
	 *
	 * @return void
	 */
	public function get_index()
	{
		Config::load('api::routes', true);
		
		$routes = Config::get('api::routes');
		
		$this->response(array_keys($routes));
	}
}
