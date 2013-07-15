<?php

/**
 * Contact service.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Service_Contact extends Service_Model
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
		
		$contacts = Model_Contact::query();
		
		if (!empty($options['id'])) {
			$contacts->where('id', $options['id']);
		}
		
		if (!empty($options['limit'])) {
			$contacts->limit($options['limit']);
		}
		
		return $contacts;
	}
	
	/**
	 * Create a new contact.
	 *
	 * @param array $data Optional data.
	 *
	 * @return Model_Contact
	 */
	public static function create($first_name, $last_name, array $data = array())
	{
		$contact = Model_Contact::forge();
		$contact->first_name = $first_name;
		$contact->last_name = $last_name;
		
		$contact->populate($data);
		
		try {
			$contact->save();
		} catch (FuelException $e) {
			print_r($e);die;
			Log::error($e);
			return false;
		}
		
		return $contact;
	}
	
	/**
	 * Updates a contact.
	 *
	 * @param Model_Contact $contact The contact to update.
	 * @param array          $data   The data to use to update the contact.
	 *
	 * @return Model_Contact
	 */
	public static function update(Model_Contact $contact, array $data = array())
	{
		$contact->populate($data);
		
		try {
			$contact->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $contact;
	}
	
	/**
	 * Deletes a contact.
	 *
	 * @param Model_Contact $contact The contact to delete.
	 *
	 * @return bool
	 */
	public static function delete(Model_Contact $contact)
	{
		try {
			$contact->delete();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
}
