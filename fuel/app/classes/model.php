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
}
