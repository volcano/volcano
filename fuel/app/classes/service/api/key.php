<?php

/**
 * API key service.
 */
class Service_Api_Key extends Service
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
			'status' => 'active',
		), $options);
		
		$api_keys = Model_Api_Key::query();
		
		if (!empty($options['seller'])) {
			$api_keys->where('seller_id', $options['seller']->id);
		}
		
		if (!empty($options['key'])) {
			$api_keys->where('key', $options['key']);
		}
		
		if (!empty($options['status']) && $options['status'] != 'all') {
			$api_keys->where('status', $options['status']);
		}
		
		if (!empty($options['limit'])) {
			$api_keys->limit($options['limit']);
		}
		
		return $api_keys;
	}
	
	/**
	 * Creates a new api key.
	 *
	 * @param Model_Seller  $seller The seller the api key belongs to.
	 * @param array         $data   Optional data.
	 *
	 * @return Model_Api_Key
	 */
	public static function create(Model_Seller $seller, array $data = array())
	{
		$api_key = Model_Api_Key::forge();
		$api_key->seller = $seller;
		$api_key->key = Str::random('alnum', 25);
		
		try {
			$api_key->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $api_key;
	}
	
	/**
	 * Updates an api key.
	 *
	 * @param Model_Api_Key $api_key The api key to update.
	 * @param array         $data    The data to use to update the api key.
	 *
	 * @return Model_Api_Key
	 */
	public static function update(Model_Api_Key $api_key, array $data = array())
	{
		$api_key->populate($data);
		
		try {
			$api_key->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $api_key;
	}
	
	/**
	 * Deletes an api key.
	 *
	 * @param Model_Api_Key $api_key The api key to delete.
	 *
	 * @return bool
	 */
	public static function delete(Model_Api_Key $api_key)
	{
		$api_key->status = 'deleted';
		
		try {
			$api_key->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
}
