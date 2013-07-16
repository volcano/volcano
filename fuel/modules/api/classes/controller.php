<?php

namespace Api;

/**
 * Base Controller.
 * 
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller extends \Fuel\Core\Controller_Rest
{
	/**
	 * Updates API response to include an HTTP error code and message.
	 *
	 * @param  array|string  $error Error message string or array of missing arguments.
	 * @param  integer       $code  Header HTTP Code.
	 *
	 * @return void
	 */
	public function error($error, $code = 500)
	{
		$common_errors = array(
			'create'  => array(
				'message' => 'Create Failed',
				'code'    => 500,
			),
			'update'  => array(
				'message' => 'Update Failed',
				'code'    => 500,
			),
			'delete'  => array(
				'message' => 'Delete Failed',
				'code'    => 500,
			),
			'invalid' => array(
				'message' => 'Invalid Requested Resource',
				'code'    => 404,
			),
		);
		
		if (is_array($error)) {
			// Grab the array keys if associative array (validation errors).
			if (array_values($error) !== $error) {
				$error = array_keys($error);
			}
			
			$message = 'Missing or Invalid Parameter(s): ' . implode(',', $error);
		} else if ($common = \Arr::get($common_errors, $error)) {
			$message = \Arr::get($common, 'message');
			$code    = \Arr::get($common, 'code');
		} else {
			$message = $error;
		}
		
		$this->response(array(
			'message' => $message,
		), $code);
	}
}
