<?php

/**
 * Gateway core transaction class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
abstract class Gateway_Core_Transaction extends Gateway_Model
{
	/**
	 * Gateway's transaction status associations.
	 *
	 * @var array
	 */
	public $statuses = array();
}
