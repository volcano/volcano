<?php

/**
 * Gateway service.
 *
 * @author Keithia Stegmann <kstegmann@static.com>
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
		
		if (!empty($options['status'])) {
			$gateways->where('status', $options['status']);
		}
		
		if (!empty($options['limit'])) {
			$gateways->limit($options['limit']);
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
			foreach ($data['meta'] as $name => $value) {
				$name_meta = Model_Gateway_Meta::name($name, $value);				
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
		if (!empty($data['status'])) {
			$gateway->status = $data['status'];
		}
		
		if (!empty($data['meta'])) {
			$meta_names = array_keys($data['meta']);
			$gateway_metas = $gateway->meta($meta_names);
			
			foreach ($meta_names as $name) {
				$value = $data['meta'][$name];
				
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
}
