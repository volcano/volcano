<?php

/**
 * Seller service.
 */
class Service_Seller extends Service
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
		
		$sellers = Model_Seller::query();
		
		if (!empty($options['id'])) {
			$sellers->where('id', $options['id']);
		}
		
		if (!empty($options['status']) && $options['status'] != 'all') {
			$sellers->where('status', $options['status']);
		}
		
		return $sellers;
	}
	
	/**
	 * Creates a new seller.
	 *
	 * @param string $name The name of the seller.
	 * @param array  $data Optional data.
	 *
	 * @return Model_Seller
	 */
	public static function create($name, array $data = array())
	{
		if (!$contact_data = Arr::get($data, 'contact')) {
			return false;
		}
		
		$seller = Model_Seller::forge();
		$seller->name = $name;
		
		$seller->populate($data);
		
		try {
			$seller->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		$contact = Service_Contact::create($contact_data);
		
		if (!$contact || !Service_Contact::link($contact, $seller, true)) {
			return false;
		}
		
		return $seller;
	}
	
	/**
	 * Updates a seller.
	 *
	 * @param Model_Seller $seller The seller to update.
	 * @param array          $data   The data to use to update the seller.
	 *
	 * @return Model_Seller
	 */
	public static function update(Model_Seller $seller, array $data = array())
	{
		$seller->populate($data);
		
		try {
			$seller->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $seller;
	}
	
	/**
	 * Deletes a seller.
	 *
	 * @param Model_Seller $seller The seller to delete.
	 *
	 * @return bool
	 */
	public static function delete(Model_Seller $seller)
	{
		$seller->status = 'deleted';
		
		try {
			$seller->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
}
