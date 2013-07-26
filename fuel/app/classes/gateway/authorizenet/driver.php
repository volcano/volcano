<?php

/**
 * Authorize.net gateway driver class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Gateway_Authorizenet_Driver extends Gateway_Driver
{
	/**
	 * Class constructor.
	 * 
	 * @param Model_Gateway $model The gateway model to use for the driver.
	 *
	 * @return void
	 */
	public function __construct(Model_Gateway $model)
	{
		parent::__construct($model);
		
		if (!$model->meta('api_login_id')) {
			throw new GatewayException('Missing Gateway Meta: api_login_id');
		} elseif (!$model->meta('transaction_key')) {
			throw new GatewayException('Missing Gateway Meta: transaction_key');
		}
		
		$api_login_id    = $model->meta('api_login_id')->value;
		$transaction_key = $model->meta('transaction_key')->value;
		$sandbox         = $model->meta('sandbox') ? $model->meta('sandbox')->value : false;

		define('AUTHORIZENET_API_LOGIN_ID', $api_login_id);
		define('AUTHORIZENET_TRANSACTION_KEY', $transaction_key);
		define('AUTHORIZENET_SANDBOX', $sandbox);
	}
}
