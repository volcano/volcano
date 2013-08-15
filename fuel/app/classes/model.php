<?php

/**
 * Base model class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model extends \Orm\Model
{
	/**
	 * Populates a model with key value pair data.
	 *
	 * @param array $data Data to populate the model with.
	 *
	 * @return void
	 */
	public function populate(array $data)
	{
		$properties = $this::properties();
		
		foreach ($data as $property => $value) {
			if (Arr::key_exists($properties, $property)) {
				$this->$property = $value;
			}
		}
	}
	
	/**
	 * Builds an array of api-safe model data.
	 *
	 * @return array
	 */
	public function to_api_array()
	{
		$data = array();
		
		$properties = $this::$_properties;
		foreach ($properties as $key => $value) {
			if (is_numeric($key)) {
				$data[$value] = $this->$value;
			} else {
				$data[$key] = $this->$key;
			}
		}
		
		return $data;
	}
	
	/**
	 * Returns whether the model's status is active.
	 *
	 * @return bool
	 */
	public function active()
	{
		if (!Arr::key_exists($this::properties(), 'status')) {
			return false;
		}
		
		return $this->status == 'active';
	}

}
