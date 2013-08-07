<?php

/**
 * Credit card validation configuration.
 *
 * Options for each credit card:
 *  length - All the allowed card number lengths, in a comma separated string.
 *  prefix - The digits the card needs to start with, in regex format.
 *  luhn   - Enable or disable card number validation by the Luhn algorithm.
 *  name   - The name of the credit card for display.
 */

return array(
	'visa' => array(
		'length' => '13,16',
		'prefix' => '4',
		'luhn'   => true,
		'name'   => 'Visa',
	),
	
	'mastercard' => array(
		'length' => '16',
		'prefix' => '5[1-5]',
		'luhn'   => true,
		'name'   => 'MasterCard',
	),
	
	'discover' => array(
		'length' => '16',
		'prefix' => '6(?:5|011)',
		'luhn'   => true,
		'name'   => 'Discover',
	),
	
	'amex' => array(
		'length' => '15',
		'prefix' => '3[47]',
		'luhn'   => true,
		'name'   => 'AmEx',
	),
	
	'default' => array(
		'length' => '13,14,15,16,17,18,19',
		'prefix' => '',
		'luhn'   => true,
	),
);
