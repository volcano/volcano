<?php

/**
 * Validation customer payment method class.
 */
class Validation_Customer_Paymentmethod
{
	/**
	 * Creates a new validation instance for payment method create.
	 *
	 * @param Model_Gateway $gateway The payment method's gateway.
	 *
	 * @return Validation
	 */
	public static function create(Model_Gateway $gateway)
	{
		$validator = Validation::forge('paymentmethod');
		
		if ($gateway->processes_credit_cards()) {
			$validator->add('account.number', 'Credit Card Number')->add_rule('creditcard')->add_rule('required');
			$validator->add('account.expiration_month', 'Credit Card Expiration Month')->add_rule('number')->add_rule('required');
			$validator->add('account.expiration_year', 'Credit Card Expiration Year')->add_rule('number')->add_rule('required');
		}
		
		$validator->add('contact', 'Payment Method Contact')->add_rule('contact', 'paymentmethod');
		$validator->add('primary', 'Primary Payment Method');
		
		return $validator;
	}
	
	/**
	 * Creates a new validation instance for payment method update.
	 *
	 * @param Model_Gateway $gateway The payment method's gateway.
	 *
	 * @return Validation
	 */
	public static function update(Model_Gateway $gateway)
	{
		// All fields are required for payment method update.
		return self::create($gateway);
	}
}
