<?php

/**
 * Seller class.
 * 
 * @author Daniel Sposito <dsposito@static.com>
 */
class Seller
{
	/**
	 * The active seller.
	 *
	 * @var Model_Seller
	 */
	protected static $active = null;
	
	/**
	 * Initializer executed when class is loaded.
	 *
	 * @return void
	 */
	public static function _init()
	{
		// @TODO REMOVE THIS TEMPORARY HACK
		$seller = Service_Seller::find_one();
		
		if ($seller) {
			self::set($seller);
		}
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
		self::$active = $seller;
	}
	
	/**
	 * Returns the active seller object.
	 *
	 * @return mixed
	 */
	public static function active()
	{
		if (empty(self::$active)) {
			return false;
		}
		
		return self::$active;
	}
}
