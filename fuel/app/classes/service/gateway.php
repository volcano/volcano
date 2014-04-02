<?php

/**
 * Gateway service.
 */
class Service_Gateway extends Service
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
		
		$gateways = Model_Gateway::query();
		
		if (!empty($options['id'])) {
			$gateways->where('id', $options['id']);
		}
		
		if (!empty($options['processor'])) {
			$gateways->where('processor', $options['processor']);
		}
		
		if (!empty($options['status'])) {
			$gateways->where('status', $options['status']);
		}
		
		if (!empty($options['seller'])) {
			$gateways->related('sellers');
			$gateways->where('sellers.id', $options['seller']->id);
		}
		
		return $gateways;
	}
	
	/**
	 * Creates a new gateway.
	 *
	 * @param string	$type		Gateway type.
	 * @param string	$processor	Gateway processor.
	 * @param array		$data		Optional data.
	 *
	 * @return Model_Gateway
	 */
	public static function create($type, $processor, array $data = array())
	{
		$gateway = Model_Gateway::forge();
		$gateway->type = $type;
		$gateway->processor = $processor;
		
		if (!empty($data['status'])) {
			$gateway->status = $data['status'];
		}
		
		if (!empty($data['meta'])) {
			$enc_key = Config::get('security.db_enc_key');
			
			foreach ($data['meta'] as $name => $value) {
				$enc_value = Crypt::encode($value, $enc_key);
				
				$name_meta = Model_Gateway_Meta::name($name, $enc_value);
				$gateway->meta[] = $name_meta;
			}
		}
		
		$gateway->populate($data);
		
		try {
			$gateway->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $gateway;
	}
	
	/**
	 * Updates a gateway.
	 *
	 * @param Model_Gateway	$gateway	The gateway to update.
	 * @param array			$data		The data to use to update the gateway.
	 *
	 * @return Model_Gateway
	 */
	public static function update(Model_Gateway $gateway, array $data = array())
	{
		$gateway->populate($data);
		
		if (!empty($data['meta'])) {
			$meta_names = array_keys($data['meta']);
			$gateway_metas = $gateway->meta($meta_names);
			
			$enc_key = Config::get('security.db_enc_key');
			
			foreach ($meta_names as $name) {
				$value = Crypt::encode($data['meta'][$name], $enc_key);
				
				if (!isset($gateway_metas[$name])) {
					$name_meta = Model_Gateway_Meta::name($name, $value);
					
					$gateway->meta[] = $name_meta;
				} else {
					$name_meta = $gateway_metas[$name];
					$name_meta->value = $value;
					
					try {
						$name_meta->save();
					} catch (FuelException $e) {
						Log::error($e);
						return false;
					}
				}
			}
		}
		
		try {
			$gateway->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return $gateway;
	}
	
	/**
	 * Deletes a gateway.
	 *
	 * @param Model_Gateway $gateway The gateway to delete.
	 *
	 * @return bool
	 */
	public static function delete(Model_Gateway $gateway)
	{
		$gateway->status = 'deleted';
		
		try {
			$gateway->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
	
	/**
	 * Links a gateway to a seller.
	 *
	 * @param Model_Gateway $gateway The gateway to link.
	 * @param Model_Seller  $seller  The seller to link the gateway to.
	 *
	 * @return bool
	 */
	public static function link(Model_Gateway $gateway, Model_Seller $seller)
	{
		$seller->gateways[] = $gateway;
		
		try {
			$seller->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
	
	/**
	 * Unlinks a gateway from a seller.
	 *
	 * @param Model_Gateway $gateway The gateway to unlink.
	 * @param Model_Seller  $seller  The seller to unlink the gateway from.
	 *
	 * @return bool
	 */
	public static function unlink(Model_Gateway $gateway, Model_Seller $seller)
	{
		unset($seller->gateways[$gateway->id]);
		
		try {
			$seller->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		return true;
	}
}
