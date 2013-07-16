<?php

/**
 * Validation class.
 * 
 * @author Daniel Sposito <dsposito@static.com>
 */
class Validation extends \Fuel\Core\Validation
{
	/**
	 * Returns a csv of validation errors.
	 *
	 * @return string
	 */
	public function errors()
	{
		return implode(', ', array_keys($this->errors));
	}
}
