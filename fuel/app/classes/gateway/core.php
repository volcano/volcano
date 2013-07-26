<?php

/**
 * Core gateway class.
 *
 * @author Daniel Sposito <dsposito@static.com>
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
