<?php

/**
 * The Error Controller.
 *
 * @author Mark Manos <mmanos@static.com>
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Error extends Controller
{
	/**
	 * The 404 action for the application.
	 *
	 * @return void
	 */
	public function action_404()
	{
		// Set a HTTP 404 output header.
		$this->response->set_status(404);
	}
}
