<?php

/**
 * Session class.
 */
class Session extends \Fuel\Core\Session
{
	/**
	 * Sets the alert type with a message with flash sessions.
	 *
	 * @param string $type    The type of alert to flash.
	 * @param string $message The message for the alert.
	 * 
	 * @return Session
	 */
	public static function set_alert($type, $message)
	{
		return static::instance()->set_flash('alert', array($type => $message));
	}
}
