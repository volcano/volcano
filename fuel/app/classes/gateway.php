<?php

/**
 * Gateway class.
 */
class Gateway
{
	/**
	 * Loaded gateway driver instance.
	 *
	 * @var Gateway_Driver
	 */
	protected static $_instance;
	
	/**
	 * Array of loaded instances.
	 *
	 * @var array
	 */
	protected static $_instances = array();
	
	/**
	 * Gets a new instance of gateway driver class.
	 *
	 * @param Model_Gateway  $gateway  The gateway model to use (for gateway auth and such).
	 * @param Model_Customer $customer The customer model to use.
	 *
	 * @return Gateway_Driver|bool
	 */
	public static function forge(Model_Gateway $gateway, Model_Customer $customer = null)
	{
		$driver_name = $gateway->processor;
		
		$class = 'Gateway_' . Str::ucwords(Inflector::denamespace($driver_name)) . '_Driver';
		if (!class_exists($class)) {
			return false;
		}
		
		$driver = new $class($gateway, $customer);
		
		static::$_instances[$driver_name] = $driver;
		is_null(static::$_instance) and static::$_instance = $driver;
		
		return $driver;
	}
	
	/**
	 * Create or return the driver instance.
	 *
	 * @param Model_Gateway  $gateway  The gateway model to use (for gateway auth and such).
	 * @param Model_Customer $customer The customer model to use.
	 *
	 * @return Gateway_Driver
	 */
	public static function instance(Model_Gateway $gateway, Model_Customer $customer = null)
	{
		$instance = $gateway->processor;
		
		if (array_key_exists($instance, static::$_instances)) {
			return static::$_instances[$instance];
		}
		
		if (static::$_instance === null) {
			static::$_instance = static::forge($gateway, $customer);
		}
		
		return static::$_instance;
	}
}

class GatewayException extends \FuelException {}
