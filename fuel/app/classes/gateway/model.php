<?php

/**
 * Gateway model class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
abstract class Gateway_Model extends Gateway_Core
{
	/**
	 * Finds a single instance.
	 * 
	 * @param int|array $options Instance identifier or filter data.
	 *
	 * @return array|null
	 */
	abstract public function find_one($options = array());
	
	/**
	 * Creates a new instance.
	 *
	 * @param $data New instance data.
	 *
	 * @return bool
	 */
	abstract public function create(array $data);
	
	/**
	 * Updates an existing instance.
	 * 
	 * @param array $data Updated instance data.
	 *
	 * @return bool
	 */
	abstract public function update(array $data);
	
	/**
	 * Deletes an existing instance.
	 *
	 * @return bool
	 */
	abstract public function delete();
}
