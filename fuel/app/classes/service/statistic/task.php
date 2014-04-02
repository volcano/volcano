<?php

/**
 * Statistic task service.
 */
class Service_Statistic_Task extends Service
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
			'order_by' => array('id' => 'desc'),
		), $options);
		
		$tasks = Model_Statistic_Task::query();
		
		if (!empty($options['id'])) {
			$tasks->where('id', $options['id']);
		}
		
		if (!empty($options['type'])) {
			$tasks->where('type', $options['type']);
		}
		
		if (!empty($options['status'])) {
			$tasks->where('status', $options['status']);
		}
		
		if (!empty($options['order_by'])) {
			foreach ($options['order_by'] as $field => $direction) {
				$tasks->order_by($field, $direction);
			}
		}
		
		return $tasks;
	}
	
	/**
	 * Begins (creates) a new statistic task record.
	 *
	 * @param string $type Type.
	 *
	 * @return Model_Statistic_Task
	 */
	public static function begin($type)
	{
		$task = Model_Statistic_Task::forge();
		$task->type = $type;
		
		try {
			$task->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $task;
	}
	
	/**
	 * Ends (updates) a statistic task record.
	 *
	 * @param Model_Statistic_Task $task    The statistic task to end.
	 * @param string               $status  Status (completed, failed).
	 * @param string               $message Optional success/error message.
	 *
	 * @return $task
	 */
	public static function end(Model_Statistic_Task $task, $status = 'completed', $message = '')
	{
		$task->status  = $status;
		$task->message = $message;
		
		try {
			$task->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $task;
	}
	
	/**
	 * Gets the last completion for a particular task name.
	 *
	 * @param string $name Name.
	 *
	 * @return Model_Statistic_Task
	 */
	public static function last($name)
	{
		return self::find_one(array(
			'name'   => $name,
			'status' => 'completed',
		));
	}
	
	/**
	 * Calculates date ranges for a particular statistic ($name) based on the last time the task was run.
	 *
	 * @param string $name Statistic name.
	 *
	 * @return array
	 */
	public static function date_ranges($name)
	{
		$current_time = Date::time()->get_timestamp();
		
		$last_task = self::last($name);
		if (!$last_task) {
			// Statistic $name has never been processed - use first seller as range's beginning.
			$last_task = Service_Seller::find_one(array('status' => 'all'));
		}
		
		$begin_time = strtotime($last_task->created_at);
		$end_time   = strtotime('tomorrow', $begin_time) - 1;
		
		// Initial range is last time until end of its day.
		$ranges = array(array(
			'begin' => Date::forge($begin_time)->format('mysql'),
			'end'   => Date::forge($end_time)->format('mysql'),
		));
		
		// Add additional 1 day ranges up to the current time.
		while ($end_time < $current_time) {
			$begin_time = strtotime('midnight', strtotime('+1 Day', $end_time));
			$end_time   = strtotime('tomorrow', $begin_time) - 1;
			
			$ranges[] = array(
				'begin' => Date::forge($begin_time)->format('mysql'),
				'end'   => Date::forge($end_time)->format('mysql'),
			);
		}
		
		return $ranges;
	}
}
