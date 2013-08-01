<?php

/**
 * Contact service.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Service_Contact extends Service
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
		
		if (!empty($options['status'])) {
			$contacts->where('status', $options['status']);
		}
		
		return $contacts;
	}
	
	/**
	 * Creates a new contact.
	 *
	 * @param string $first_name Contact first name.
	 * @param string $last_name  Contact last name.
	 * @param array  $data       Optional data.
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
	
	/**
	 * Links a contact to another model.
	 *
	 * @param Model_Contact $contact The contact to link.
	 * @param Model         $model   The model to link the contact to.
	 *
	 * @return bool
	 */
	public static function link(Model_Contact $contact, Model $model)
	{
		$model->contacts[] = $contact;
		
		try {
			$model->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
	
	/**
	 * Unlinks a contact from a model.
	 *
	 * @param Model_Contact $contact The contact to unlink.
	 * @param Model         $model   The model to unlink the contact from.
	 *
	 * @return bool
	 */
	public static function unlink(Model_Contact $contact, Model $model)
	{
		unset($model->contacts[$contact->id]);
		
		try {
			$model->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
}
