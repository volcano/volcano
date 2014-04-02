<?php

/**
 * Core gateway class.
 */
abstract class Gateway_Core
{
	/**
	 * The gateway driver instance.
	 *
	 * @var Gateway_Driver
	 */
	protected $driver;
	
	/**
	 * Class constructor.
	 * 
	 * @param Gateway_Driver $driver The driver to use.
	 *
	 * @return void
	 */
	public function __construct(Gateway_Driver $driver)
	{
		$this->driver = $driver;
	}
}
