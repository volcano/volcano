<?php

namespace Api;

use Config;
use Inflector;

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
		
		$endpoints = array();
		foreach ($routes as $route => $actions) {
			foreach ($actions as $namespace => $action) {
				$namespaces = explode('.', $namespace);
				
				$namespace = array_shift($namespaces);
				$name      = array_pop($namespaces);
				if (!empty($namespaces)) {
					$name .= '-' . implode('-', $namespaces);
				}
				
				$method    = $action[0];
				$path      = $action[1]->path;
				
				$endpoints[$namespace][$name] = array(
					'method' => $method,
					'path'   => $path,
				);
			}
		}
		
		$this->response($endpoints);
	}
}
