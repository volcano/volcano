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
	 * @param Model_Gateway  $model    The gateway model to use for the driver.
	 * @param Model_Customer $customer The customer model to use for the driver.
	 *
	 * @return void
	 */
	public function __construct(Model_Gateway $model, Model_Customer $customer = null)
	{
		parent::__construct($model, $customer);
		
		if (!$model->meta('api_login_id')) {
			throw new GatewayException('Missing Gateway Meta: api_login_id');
		} elseif (!$model->meta('transaction_key')) {
			throw new GatewayException('Missing Gateway Meta: transaction_key');
		}
		
		$enc_key = Config::get('security.db_enc_key');
		
		$api_login_id    = Crypt::decode($model->meta('api_login_id')->value, $enc_key);
		$transaction_key = Crypt::decode($model->meta('transaction_key')->value, $enc_key);
		$sandbox         = $model->meta('sandbox') ? Crypt::decode($model->meta('sandbox')->value, $enc_key) : false;
		
		define('AUTHORIZENET_API_LOGIN_ID', $api_login_id);
		define('AUTHORIZENET_TRANSACTION_KEY', $transaction_key);
		define('AUTHORIZENET_SANDBOX', $sandbox);
	}
}
