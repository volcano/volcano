<?php

/**
 * Contact service.
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
	 * @param array $data Contact data.
	 *
	 * @return Model_Contact
	 */
	public static function create(array $data)
	{
		$contact = Model_Contact::forge();
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
	 * @param array         $data    The data to use to update the contact.
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
	 * @param bool          $primary Whether or not to set as primary contact for model.
	 *
	 * @return bool
	 */
	public static function link(Model_Contact $contact, Model $model, $primary = false)
	{
		$model->contacts[] = $contact;
		
		try {
			$model->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		if ($primary) {
			self::set_primary($contact, $model);
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
		// A primary contact cannot be unlinked.
		if (self::primary($contact, $model) == $contact) {
			return false;
		}
		
		unset($model->contacts[$contact->id]);
		
		try {
			$model->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
	
	/**
	 * Gets a model's primary contact.
	 *
	 * @param Model $model Model.
	 *
	 * @return Model_Contact
	 */
	public static function primary(Model $model)
	{
		if ($model instanceof Model_Seller) {
			$type = 'seller';
		} elseif ($model instanceof Model_Customer) {
			$type = 'customer';
		} else {
			return false;
		}
		
		$result = DB::select('contact_id')->from("{$type}_contacts")
			->where("{$type}_id", $model->id)
			->where('primary', 1)
			->limit(1)
			->execute();
		
		$contact_id = Arr::get($result, '0.contact_id');
		if (!$contact_id) {
			return false;
		}
		
		$contact = self::find_one($contact_id);
		if (!$contact) {
			return false;
		}
		
		return $contact;
	}
	
	/**
	 * Sets a model's primary contact.
	 *
	 * @param Model_Contact $contact Contact.
	 * @param Model         $model   Model.
	 * 
	 * @return bool
	 */
	protected static function set_primary(Model_Contact $contact, Model $model)
	{
		if ($model instanceof Model_Seller) {
			$type = 'seller';
		} elseif ($model instanceof Model_Customer) {
			$type = 'customer';
		} else {
			return false;
		}
		
		$existing = self::primary($contact, $model);
		if ($existing) {
			// Unset existing primary.
			DB::update("{$type}_contacts")
				->set(array('primary' => null))
				->where("{$type}_id", $model->id)
				->execute();
		}
		
		// Set new primary.
		$result = DB::update("{$type}_contacts")
			->set(array('primary' => 1))
			->where("{$type}_id", $model->id)
			->where('contact_id', $contact->id)
			->execute();
		
		if ($result['rows_affected']) {
			return true;
		}
		
		return false;
	}
}
