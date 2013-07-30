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
	public $gateway;
	
	/**
	 * The customer model for the driver.
	 *
	 * @var Model_Customer
	 */
	public $customer;
	
	/**
	 * Class constructor.
	 * 
	 * @param Model_Gateway  $gateway  The gateway model to use for the driver.
	 * @param Model_Customer $customer The customer model to use for the driver.
	 *
	 * @return void
	 */
	public function __construct(Model_Gateway $gateway, Model_Customer $customer = null)
	{
		$this->gateway = $gateway;
		$this->customer = $customer;
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
		$instance = self::forge($this->gateway, $this->customer, $method);
		
		if (!empty($args)) {
			$data = $instance->find_one($args[0]);
			
			if (!empty($data)) {
				$instance->set($data);
			}
		}
		
		return $instance;
	}
	
	/**
	 * Gets a new instance of gateway $class_name.
	 *
	 * @param Model_Gateway  $gateway    The gateway model to use for the driver.
	 * @param Model_Customer $customer   The customer model to use for the driver.
	 * @param string         $class_name The class name to call on the driver.
	 *
	 * @return Gateway_Model
	 */
	public static function forge(Model_Gateway $gateway, Model_Customer $customer = null, $class_name)
	{
		$driver_name = str_replace('Gateway_', '', get_called_class());
		$driver_name = str_replace('_Driver', '', $driver_name);
		
		$class = 'Gateway_' . Str::ucwords(Inflector::denamespace($driver_name)) . '_' . Str::ucwords(Inflector::denamespace($class_name));
		
		if (!class_exists($class)) {
			throw new GatewayException('Call to undefined class ' . $class);
		}
		
		$driver = Gateway::instance($gateway, $customer);
		
		return new $class($driver);
	}
}
