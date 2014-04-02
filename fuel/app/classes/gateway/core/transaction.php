<?php

/**
 * Gateway core transaction class.
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
