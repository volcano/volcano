<?php

/**
 * Seller event service.
 */
class Service_Seller_Event extends Service
{
	/**
	 * Query models based on optional filters passed in.
	 *
	 * @param array $args The optional data to use.
	 *
	 * @return Query
	 */
	protected static function query(array $args = array())
	{
		$args = array_merge(array(
			'status' => 'active',
		), $args);
		
		$seller_events = Model_Seller_Event::query();
		
		if (!empty($args['id'])) {
			$seller_events->where('id', $args['id']);
		}
		
		if (!empty($args['seller'])) {
			$seller_events->where('seller_id', $args['seller']->id);
		}
		
		if (!empty($args['event'])) {
			$seller_events->related('event');
			$seller_events->where('event.name', $args['event']);
		}
		
		if (!empty($args['status'])) {
			$seller_events->where('status', $args['status']);
		}
		
		return $seller_events;
	}
	
	/**
	 * Creates a new seller event.
	 *
	 * @param Model_Seller $seller   The seller for the event relation.
	 * @param Model_Event  $event    The event for the event relation.
	 * @param string       $callback The callback for the seller event.
	 * @param array        $data     Optional data.
	 *
	 * @return Model_Seller_Event
	 */
	public static function create(Model_Seller $seller, Model_Event $event, $callback, array $data = array())
	{
		$seller_event = Model_Seller_Event::forge();
		$seller_event->seller   = $seller;
		$seller_event->event    = $event;
		$seller_event->callback = $callback;
		
		$seller_event->populate($data);
		
		try {
			$seller_event->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $seller_event;
	}
	
	/**
	 * Updates a seller event.
	 *
	 * @param Model_Seller_Event $seller_event The seller event to update.
	 * @param array              $data         The data to use to update the seller event.
	 *
	 * @return Model_Seller_Event
	 */
	public static function update(Model_Seller_Event $seller_event, array $data = array())
	{
		if ($event_name = Arr::get($data, 'event')) {
			$event = \Service_Event::find_one(array('name' => $event_name));
			if (!$event) {
				return false;
			}
			
			$seller_event->event = $event;
		}
		
		$seller_event->populate($data);
		
		try {
			$seller_event->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $seller_event;
	}
	
	/**
	 * Deletes a seller event.
	 *
	 * @param Model_Seller_Event $seller_event The seller event to delete.
	 *
	 * @return bool
	 */
	public static function delete(Model_Seller_Event $seller_event)
	{
		$seller_event->status = 'deleted';
		
		try {
			$seller_event->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
}
