<?php

/**
 * Seller class.
 */
class Seller
{
	/**
	 * Namespace to use for sessions.
	 *
	 * @var string
	 */
	protected static $namespace = 'seller';
	
	/**
	 * The active seller.
	 *
	 * @var Model_Seller
	 */
	protected static $active = null;
	
	/**
	 * Loads a seller based on session.
	 *
	 * @return void
	 */
	public static function load()
	{
		Config::load('api', true);

		$seller_id = Session::get(self::$namespace . '.id');
		if ($seller_id) {
			$seller = Service_Seller::find_one($seller_id);
		} elseif ($api_key = Input::param('api_key', Config::get('api.key'))) {
			$api_key = Service_Api_Key::find_one(array('key' => $api_key));
			$seller  = $api_key->seller;
		} else {
			$seller = Service_Seller::find_one();
		}
		
		if (!$seller || !$seller->active()) {
			return false;
		}
		
		self::set($seller);
		
		return true;
	}
	
	/**
	 * Sets the active seller.
	 *
	 * @param Model_Seller $seller The seller to set as active.
	 *
	 * @return void
	 */
	public static function set(Model_Seller $seller)
	{
		Session::set(self::$namespace . '.id', $seller->id);
		
		self::$active = $seller;
	}
	
	/**
	 * Returns the active seller object.
	 *
	 * @return Model_Seller|bool
	 */
	public static function active()
	{
		if (empty(self::$active)) {
			$loaded = self::load();
			
			// No seller was found.
			if (!$loaded) {
				return false;
			}
		}
		
		return self::$active;
	}
	
	/**
	 * Returns all sellers.
	 *
	 * @return array
	 */
	public static function all()
	{
		return Service_Seller::find();
	}
}
