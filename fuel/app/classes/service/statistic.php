<?php

/**
 * Statistic service.
 */
class Service_Statistic extends Service
{
	/**
	 * Query models based on optional filters passed in.
	 *
	 * @param array $options The optional options to use.
	 *
	 * @return Query
	 */
	protected static function query(array $options = array())
	{
		$options = array_merge(array(
			'order_by' => array('date' => 'asc'),
		), $options);
		
		$statistics = Model_Statistic::query();
		
		if (!empty($options['id'])) {
			$statistics->where('id', $options['id']);
		}
		
		if (!empty($options['seller'])) {
			$statistics->where('seller_id', $options['seller']->id);
		}
		
		if (!empty($options['type'])) {
			$statistics->where('type', $options['type']);
		}
		
		if (!empty($options['name'])) {
			if (is_array($options['name'])) {
				$statistics->where('name', 'IN', $options['name']);
			} else {
				$statistics->where('name', $options['name']);
			}
		}
		
		if (!empty($options['order_by'])) {
			foreach ($options['order_by'] as $field => $direction) {
				$statistics->order_by($field, $direction);
			}
		}
		
		return $statistics;
	}
	
	/**
	 * Creates a new statistic.
	 *
	 * @param Model_Seller $seller The seller the statistic belongs to.
	 * @param string       $type   The type of statistic (customer, product, etc).
	 * @param Date         $date   Date.
	 * @param string       $name   Name.
	 * @param string       $value  Value.
	 *
	 * @return Model_Statistic
	 */
	public static function create(Model_Seller $seller, $type, Date $date, $name, $value)
	{
		$statistic = Model_Statistic::forge();
		$statistic->seller = $seller;
		$statistic->type   = $type;
		$statistic->name   = $name;
		$statistic->value  = $value;
		$statistic->date   = $date->format('mysql_date');
		
		try {
			$statistic->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		Service_Event::trigger('statistic.create', $statistic->seller, $statistic->to_array());
		
		return $statistic;
	}
	
	/**
	 * Gets the most recent values for a particular statistic.
	 *
	 * @param array $options The optional options to use.
	 *
	 * @return array
	 */
	public static function recent(array $options = array())
	{
		$options['order_by'] = array('date' => 'desc', 'name' => 'desc');
		$options['limit']    = count((array) Arr::get($options, 'name'));
		
		return self::find($options);
	}
}
