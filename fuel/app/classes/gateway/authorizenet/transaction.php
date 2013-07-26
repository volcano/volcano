<?php

/**
 * Authorize.net gateway transaction class.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Gateway_Authorizenet_Transaction extends Gateway_Core_Transaction
{
	/**
	 * Finds a single instance.
	 * 
	 * @param int|array $options Instance identifier or filter data.
	 *
	 * @return array|null
	 */
	public function find_one($options = array()) {}
	
	/**
	 * Creates a new instance.
	 *
	 * @param $data New instance data.
	 *
	 * @return bool
	 */
	public function create(array $data) {}
	
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
	
	/**
	 * Creates an auth transaction to verify credit card.
	 *
	 * @param array $data The credit card data to use to verify.
	 *
	 * @return bool
	 */
	public function auth(array $data)
	{
		$authorize_aim = new AuthorizeNetAIM();
		$authorize_aim->amount = 1.00;
		$authorize_aim->card_num = $data['card_number'];
		$authorize_aim->exp_date = $data['card_exp_month'] . '/' . $data['card_exp_year'];
		$authorize_aim->allow_partial_auth = true;
		
		$response = $authorize_aim->authorizeOnly();
		
		if ($response->approved == true) {
			return true;
		}
		
		Log::error('Auth transaction failed.');
		
		return false;
	}
}
