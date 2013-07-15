<?php

/**
 * Base model.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Model_Base extends \Orm\Model
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
		foreach ($data as $property => $value) {
			if ($this::property($property) !== false) {
				$this->$property = $value;
			}
		}
	}
}
