<?php

namespace Api;

/**
 * Base controller class.
 * 
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller extends \Fuel\Core\Controller_Rest
{
	/**
	 * Routes controller requests.
	 * 
	 * Differences from parent: fixes a bug for custom auth method and adds custom no auth error.
	 *
	 * @param string $resource  Controller action name.
	 * @param array  $arguments Arguments.
	 * 
	 * @return mixed
	 */
	public function router($resource, $arguments)
	{
		\Config::load('rest', true);
		
		// If no (or an invalid) format is given, auto detect the format
		if (is_null($this->format) or ! array_key_exists($this->format, $this->_supported_formats)) {
			// auto-detect the format
			$this->format = array_key_exists(\Input::extension(), $this->_supported_formats) ? \Input::extension() : $this->_detect_format();
		}
		
		// Get the configured auth method if none is defined
		$this->auth === null and $this->auth = \Config::get('rest.auth');
		
		//Check method is authorized if required, and if we're authorized
		if ($this->auth == 'basic') {
			$valid_login = $this->_prepare_basic_auth();
		} elseif ($this->auth == 'digest') {
			$valid_login = $this->_prepare_digest_auth();
		} elseif (method_exists($this, $this->auth)) {
			$valid_login = $this->{$this->auth}();
			if ($valid_login instanceof \Response) {
				return $valid_login;
			}
		} else {
			$valid_login = false;
		}
		
		// If the request passes auth then execute as normal
		if (empty($this->auth) or $valid_login) {
			// If they call user, go to $this->post_user();
			$controller_method = strtolower(\Input::method()) . '_' . $resource;
			
			// Fall back to action_ if no rest method is provided
			if ( ! method_exists($this, $controller_method)) {
				$controller_method = 'action_'.$resource;
			}
			
			// If method is not available, set status code to 404
			if (method_exists($this, $controller_method)) {
				return call_user_func_array(array($this, $controller_method), $arguments);
			} else {
				$this->response->status = $this->no_method_status;
				return;
			}
		} else {
			$this->response(array('message' => 'Missing or Invalid Authorization'), 401);
		}
	}
	
	/**
	 * Checks for api key authentication.
	 *
	 * @return bool
	 */
	protected function _prepare_key_auth()
	{
		\Config::load('api', true);
		
		$api_key = \Input::param('api_key', \Config::get('api.key'));
		if (!$api_key) {
			return false;
		}
		
		$api_key = \Service_Api_Key::find_one(array(
			'key' => $api_key,
		));
		
		if (!$api_key) {
			return false;
		}
		
		if ($api_key->seller) {
			\Seller::set($api_key->seller);
		}
		
		return true;
	}
}
