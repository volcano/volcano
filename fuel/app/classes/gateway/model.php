<?php

/**
 * Gateway model class.
 */
abstract class Gateway_Model extends Gateway_Core
{
	/**
	 * Data for the current instance.
	 *
	 * @var array
	 */
	protected $data = array();
	
	/**
	 * Sets the data for the current instance.
	 *
	 * @param array $data The data to use.
	 * 
	 * @return void
	 */
	public function set(array $data)
	{
		$this->data = $data;
	}
	
	/**
	 * Resets the data for the current instance.
	 * 
	 * @return void
	 */
	public function reset()
	{
		$this->data = null;
	}
	
	/**
	 * Gets the ID of the current instance.
	 *
	 * @return string
	 */
	public function id()
	{
		return $this->data('id');
	}
	
	/**
	 * Gets a property from instance data.
	 *
	 * @param string $key     The key to get from data.
	 * @param mixed  $default The default value to use if key not found.
	 *
	 * @return mixed
	 */
	public function data($key = null, $default = null)
	{
		if (!empty($key)) {
			return Arr::get($this->data, $key, $default);
		}
		
		return $this->data;
	}
	
	
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
