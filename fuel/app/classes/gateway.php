<?php

/**
 * Gateway class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Gateway
{
	/**
	 * Loaded gateway driver instance.
	 *
	 * @var Billing
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
	 * @param Model_Gateway $model The gateway model to use (for gateway auth and such).
	 *
	 * @return Gateway_Driver
	 */
	public static function forge(Model_Gateway $model)
	{
		$driver_name = $model->processor;
		
		$class = 'Gateway_' . Str::ucwords(Inflector::denamespace($driver_name)) . '_Driver';
		$driver = new $class($model);
		
		static::$_instances[$driver_name] = $driver;
		is_null(static::$_instance) and static::$_instance = $driver;
		
		return $driver;
	}
	
	/**
	 * Create or return the driver instance.
	 *
	 * @param Model_Gateway $model The gateway model to use (for gateway auth and such).
	 *
	 * @return Gateway_Driver
	 */
	public static function instance(Model_Gateway $model)
	{
		$instance = $model->processor;
		
		if (array_key_exists($instance, static::$_instances)) {
			return static::$_instances[$instance];
		}
		
		if (static::$_instance === null) {
			static::$_instance = static::forge($model);
		}
		
		return static::$_instance;
	}
}

class GatewayException extends \FuelException {}
