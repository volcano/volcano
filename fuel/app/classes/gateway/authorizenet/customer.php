<?php

/**
 * Authorize.net gateway customer class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Gateway_Authorizenet_Customer extends Gateway_Core_Customer
{
	/**
	 * Gets the customer profile.
	 *
	 * @param int $profile_id The profile ID to get.
	 *
	 * @return array|bool
	 */
	public function find_one($options = array())
	{
		if (is_numeric($options)) {
			$id = $options;
		}
		
		$request = new AuthorizeNetCIM();
		
		$response = $request->getCustomerProfile($id);
		
		if (!$response->isOk()) {
			Log::error('Unable to get Authorize.net customer profile.');
			return false;
		}
		
		return $response->xml->profile;
	}
	
	/**
	 * Creates the customer profile.
	 *
	 * @param array $data The data to us to create the profile.
	 *
	 * @return bool
	 */
	public function create(array $data)
	{
		$request = new AuthorizeNetCIM();
		
		$profile = new AuthorizeNetCustomer();
		$profile->merchantCustomerId = $data['client_id'];
		$profile->email = $data['email'];
		
		$response = $request->createCustomerProfile($profile);
		
		if (!$response->isOk()) {
			$profile_id = preg_match('/A duplicate record with ID ([0-9]+) already exists./i', $response->getMessageText(), $matches);
			
			if (isset($matches[1])) {
				return $matches[1];
			}
			
			Log::error('Unable to create Authorize.net customer profile.');
			return false;
		}
		
		return $response->getCustomerProfileId();
	}
	
	/**
	 * Updates an existing instance.
	 * 
	 * @param array $data Updated instance data.
	 *
	 * @return bool
	 */
	public function update(array $data) {}
	
	/**
	 * Deletes an existing instance.
	 *
	 * @return bool
	 */
	public function delete() {}
}
