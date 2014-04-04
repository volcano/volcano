<?php

/**
 * Seller callback service.
 */
class Service_Seller_Callback extends Service
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
		
		$callbacks = Model_Seller_Callback::query();
		
		if (!empty($args['id'])) {
			$callbacks->where('id', $args['id']);
		}
		
		if (!empty($args['seller'])) {
			$callbacks->where('seller_id', $args['seller']->id);
		}
		
		if (!empty($args['event'])) {
			$callbacks->related('event');
			$callbacks->where('event.name', $args['event']);
		}
		
		if (!empty($args['status'])) {
			$callbacks->where('status', $args['status']);
		}
		
		return $callbacks;
	}
	
	/**
	 * Creates a new seller callback.
	 *
	 * @param Model_Seller $seller   The seller for the callback relation.
	 * @param Model_Event  $event    The event for the callback relation.
	 * @param string       $url      The url for the seller callback.
	 * @param array        $data     Optional data.
	 *
	 * @return Model_Seller_Callback
	 */
	public static function create(Model_Seller $seller, Model_Event $event, $url, array $data = array())
	{
		$callback = Model_Seller_Callback::forge();
		$callback->seller = $seller;
		$callback->event  = $event;
		$callback->url    = $url;
		
		$callback->populate($data);
		
		try {
			$callback->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $callback;
	}
	
	/**
	 * Updates a seller callback.
	 *
	 * @param Model_Seller_Callback $callback The seller callback to update.
	 * @param array                 $data     The data to use to update the seller callback.
	 *
	 * @return Model_Seller_Callback
	 */
	public static function update(Model_Seller_Callback $callback, array $data = array())
	{
		if ($event_name = Arr::get($data, 'event')) {
			$event = \Service_Event::find_one(array('name' => $event_name));
			if (!$event) {
				return false;
			}
			
			$callback->event = $event;
		}
		
		$callback->populate($data);
		
		try {
			$callback->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $callback;
	}
	
	/**
	 * Deletes a seller callback.
	 *
	 * @param Model_Seller_Callback $callback The seller callback to delete.
	 *
	 * @return bool
	 */
	public static function delete(Model_Seller_Callback $callback)
	{
		$callback->status = 'deleted';
		
		try {
			$callback->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
}
