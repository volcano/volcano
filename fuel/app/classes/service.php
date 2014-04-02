<?php

/**
 * Base service class.
 */
class Service
{
	/**
	 * Query models based on optional filters passed in.
	 *
	 * @param array $options The optional options to use.
	 *
	 * @return Query
	 */
	protected static function query(array $options = array()) {}
	
	/**
	 * Find models based on optional filters passed in.
	 *
	 * @param array $options The optional options to use.
	 *
	 * @return array
	 */
	public static function find(array $options = array())
	{
		$query = static::query($options);
		
		if (!empty($options['offset'])) {
			$query->rows_offset($options['offset']);
		}
		
		if (!empty($options['limit'])) {
			$query->rows_limit($options['limit']);
		}
		
		return $query->get();
	}
	
	/**
	 * Find a single model based on filters passed in.
	 *
	 * @param int|array $options The model ID to get or array of optional options to use.
	 *
	 * @return null|Model
	 */
	public static function find_one($options = array())
	{
		if (is_numeric($options)) {
			$options = array('id' => $options);
		}
		
		$query = static::find(array_merge(array(
			'limit' => 1,
		), $options));
		
		return $query ? current($query) : null;
	}
	
	/**
	 * Counts models based on optional filters passed in.
	 *
	 * @param array $options The optional options to use.
	 *
	 * @return int
	 */
	public static function count(array $options = array())
	{
		$query = static::query($options);
		
		return $query->count();
	}
}
