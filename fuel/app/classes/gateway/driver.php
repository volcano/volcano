<?php

/**
 * Gateway driver class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
abstract class Gateway_Driver
{
	/**
	 * The gateway model for the driver.
	 *
	 * @var Model_Gateway
	 */
	public $model;
	
	/**
	 * Class constructor.
	 * 
	 * @param Model_Gateway $model The gateway model to use for the driver.
	 *
	 * @return void
	 */
	public function __construct(Model_Gateway $model)
	{
		$this->model = $model;
	}
	
	/**
	 * Forges an instance of the class called on the driver.
	 *
	 * @param string $method The method called.
	 * @param array  $args   The arguments passed.
	 * 
	 * @return Gateway_Model
	 */
	public function __call($method, $args)
	{
		$instance = self::forge($this->model, $method);
		
		if (!empty($args)) {
			$instance = $instance->find_one($args[0]);
		}
		
		return $instance;
	}
	
	/**
	 * Gets a new instance of gateway model $class_name.
	 *
	 * @param Model_Gateway $model      The gateway model to use for the driver.
	 * @param string        $class_name The class name to call on the driver.
	 *
	 * @return Gateway_Model
	 */
	public static function forge(Model_Gateway $model, $class_name)
	{
		$driver_name = str_replace('Gateway_', '', get_called_class());
		$driver_name = str_replace('_Driver', '', $driver_name);
		
		$class = 'Gateway_' . Str::ucwords(Inflector::denamespace($driver_name)) . '_' . Str::ucwords(Inflector::denamespace($class_name));
		
		if (!class_exists($class)) {
			throw new GatewayException('Call to undefined class ' . $class);
		}
		
		$driver = Gateway::instance($model);
		
		return new $class($driver);
	}
}
