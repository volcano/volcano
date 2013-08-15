<?php

/**
 * The settings controller.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Settings extends Controller
{
	/**
	 * Switches the active seller.
	 * 
	 * @param int $id Seller ID.
	 *
	 * @return void
	 */
	public function action_switch($id = null)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$seller = Service_Seller::find_one($id);
		if (!$seller) {
			throw new HttpNotFoundException;
		}
		
		Seller::set($seller);
		
		Session::set_alert('success', "You are now viewing as seller \"{$seller->name}\".");
		Response::redirect('/');
	}
}
