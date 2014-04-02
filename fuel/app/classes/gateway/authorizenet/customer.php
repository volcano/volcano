<?php

/**
 * Authorize.net gateway customer class.
 */
class Gateway_Authorizenet_Customer extends Gateway_Core_Customer
{
	/**
	 * Gets the customer profile.
	 *
	 * @param int|array $options Instance identifier or filter data.
	 *
	 * @return array|null
	 */
	public function find_one($options = array()) {}
	
	/**
	 * Creates the customer profile.
	 *
	 * @param array $data The data to us to create the profile.
	 *
	 * @return bool
	 */
	public function create(array $data)
	{
		if (!$customer = Arr::get($data, 'customer')) {
			return false;
		}
		
		if (!$contact = Arr::get($data, 'contact')) {
			return false;
		}
		
		$request = new AuthorizeNetCIM();
		
		$profile = new AuthorizeNetCustomer();
		$profile->merchantCustomerId = $customer->id;
		$profile->email = $contact->email;
		
		$response = $request->createCustomerProfile($profile);
		
		if (!$response->isOk()) {
			preg_match('/A duplicate record with ID ([0-9]+) already exists./i', $response->getMessageText(), $matches);
			
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
