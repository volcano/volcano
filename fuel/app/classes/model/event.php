<?php

/**
 * Event model.
 */
class Model_Event extends Model
{
	protected static $_properties = array(
		'id',
		'name',
	);
	
	/**
	 * Returns this model's string representation.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return Inflector::titleize($this->name, '.');
	}
}
