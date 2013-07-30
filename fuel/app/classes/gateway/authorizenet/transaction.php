<?php

/**
 * Authorize.net gateway transaction class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Gateway_Authorizenet_Transaction extends Gateway_Core_Transaction
{
	/**
	 * Finds a single instance.
	 * 
	 * @param int|array $options Instance identifier or filter data.
	 *
	 * @return array|null
	 */
	public function find_one($options = array()) {}
	
	/**
	 * Creates a new instance.
	 *
	 * @param $data New instance data.
	 *
	 * @return bool
	 */
	public function create(array $data) {}
	
	/**
	 * Updates an existing instance.
	 * 
	 * @param array $data Updated instance data.
	 *
	 * @return bool
	 */
	public function update(array $data) {}
	
	/**
	 * Deletes an existing instance.
	 *
	 * @return bool
	 */
	public function delete() {}
}
