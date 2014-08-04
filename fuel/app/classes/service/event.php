<?php

/**
 * Event service.
 */
class Service_Event extends Service
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
		$events = Model_Event::query();
		
		if (!empty($options['id'])) {
			$events->where('id', $options['id']);
		}
		
		if (!empty($options['name'])) {
			$events->where('name', $options['name']);
		}
		
		return $events;
	}
	
	/**
	 * Creates a new event.
	 *
	 * @param string $name The name of the event.
	 *
	 * @return Model_Event
	 */
	public static function create($name)
	{
		$event = Model_Event::forge();
		$event->name = $name;
		
		try {
			$event->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $event;
	}
	
	/**
	 * Triggers an event.
	 *
	 * @param string       $name   The name of the event to trigger.
	 * @param Model_Seller $seller The seller for which to trigger the event.
	 * @param array        $data   Optional data to send to the event callback.
	 *
	 * @return bool
	 */
	public static function trigger($name, Model_Seller $seller, array $data = array())
	{
		$callback = Service_Seller_Callback::find_one(array(
			'seller' => $seller,
			'event'  => $name,
		));
		
		if (!$callback) {
			return false;
		}
		
		// Event name should always be included in the post data.
		$data['event'] = $name;
		
		$request = Request::forge($callback->url, 'curl');
		$request->set_method('post');
		$request->set_params($data);
		
		try {
			$request->execute();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
}
