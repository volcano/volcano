<?php

/**
 * Validation class.
 */
class Validation extends \Fuel\Core\Validation
{
	/**
	 * Returns a csv of validation errors.
	 *
	 * @return string
	 */
	public function errors()
	{
		$errors = array();
		foreach ($this->errors as $key => $error) {
			if (($message = $this->get_message($key)) && is_array($message)) {
				foreach ($message as $msg) {
					$errors[] = "$key.$msg";
				}
				
			} else {
				$errors[] = $key;
			}
		}
		
		return implode(', ', $errors);
	}
	
	/**
	 * Validates that the provided value is numeric.
	 *
	 * @param string $val Value to validate.
	 *
	 * @return bool
	 */
	public function _validation_number($val)
	{
		return $this->_empty($val) || $this->_validation_valid_string($val, array('numeric'));
	}
	
	/**
	 * Validates that the provided value is allowed.
	 *
	 * @param string $value  Value to validate.
	 * @param array  $values Acceptable values.
	 *
	 * @return bool
	 */
	public function _validation_valid_value($value, array $values)
	{
		if (!in_array($value, $values)) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Validates contact data.
	 *
	 * @param array  $data   Contact data to validate.
	 * @param string $type   Contact type.
	 * @param string $action Type of contact validation (create or update).
	 *
	 * @return bool
	 */
	public function _validation_contact($data, $type = 'customer', $action = 'create')
	{
		// Allow an existing contact ID to be used for payment methods.
		if ($type == 'paymentmethod' && is_numeric($data)) {
			if (Service_Contact::find_one($data)) {
				return true;
			} else {
				return false;
			}
		}
		
		$data = !is_array($data) ? (array) $data : $data;
		
		if (!in_array($action, array('create', 'update'))) {
			return false;
		}
		
		$validator = Validation_Contact::$action($type);
		if (!$validator->run($data)) {
			$this->set_message('contact', array_keys($validator->errors));
			return false;
		}
		
		return true;
	}
	
	/**
	 * Validates a credit card number.
	 *
	 * @param string $val Credit card number to validate.
	 * @param string $type Credit card type (Visa, Discover, etc).
	 *
	 * @return bool
	 */
	public function _validation_creditcard($val, $type = null)
	{
		if ($this->_empty($val)) {
			return false;
		}
		
		// Remove all non-digit characters from the string.
		if (($val = preg_replace('/\D+/', '', $val)) === '') {
			return false;
		}
		
		if ($type == null) {
			$type = $this->creditcard_type($val, 'key');
		} elseif (is_array($type)) {
			foreach ($type as $t) {
				// Test each type for validity.
				if ($this->_validation_creditcard($val, $t)) {
					return true;
				}
			}
			
			return false;
		}
		
		Config::load('creditcards', true);
		
		$cards = Config::get('creditcards');
		
		$type = strtolower($type);
		
		if (!isset($cards[$type])) {
			return false;
		}
		
		$length = strlen($val);
		
		// Validate card length by the card type.
		if (!in_array($length, preg_split('/\D+/', $cards[$type]['length']))) {
			return false;
		}
		
		// Check card number prefix.
		if (!preg_match('/^'.$cards[$type]['prefix'].'/', $val)) {
			return false;
		}
		
		// No Luhn check required.
		if ($cards[$type]['luhn'] == false) {
			return true;
		}
		
		// Add credit card type to the array of validated data.
		Arr::set($this->validated, 'account.provider', $this->creditcard_type($val, 'name'));
		
		return $this->luhn_check($val);
	}
	
	/**
	 * Performs the Luhn formula against a numeric value.
	 * 
	 * @see http://en.wikipedia.org/wiki/Luhn_algorithm
	 *
	 * @param string $val Number to validate.
	 * 
	 * @return bool
	 */
	protected function luhn_check($val)
	{
		// Force the value to be a string as this method uses string functions.
		// Converting to an integer may pass PHP_INT_MAX and result in an error!
		$val = (string) $val;
		
		// Luhn can only be used on numbers!
		if (!ctype_digit($val)) {
			return false;
		}
		
		$length = strlen($val);
		
		$checksum = 0;
		
		for ($i = $length - 1; $i >= 0; $i -= 2) {
			// Add up every 2nd digit, starting from the right.
			$checksum += substr($val, $i, 1);
		}
		
		for ($i = $length - 2; $i >= 0; $i -= 2) {
			// Add up every 2nd digit doubled, starting from the right.
			$double = substr($val, $i, 1) * 2;
			
			// Subtract 9 from the double where value is greater than 10.
			$checksum += ($double >= 10) ? ($double - 9) : $double;
		}
		
		// If the checksum is a multiple of 10, the number is valid.
		return ($checksum % 10 === 0);
	}
	
	
	/**
	 * Gets a credit card type.
	 *
	 * @param string $val Credit card type.
	 * @param string $return The type of credit card data to return.
	 *
	 * @return string|bool
	 */
	protected function creditcard_type($val, $return = 'name')
	{
		// Remove all non-digit characters from the number
		if (($val = preg_replace('/\D+/', '', $val)) === '') {
			return false;
		}
		
		if ($this->_empty($val)) {
			return 'unknown';
		}
		
		Config::load('creditcards', true);
		
		$cards = Config::get('creditcards');
		
		foreach ($cards as $key => $card) {
			if (empty($card['prefix'])) {
				continue;
			}
			
			$prefixes = explode(',', $card['prefix']);
			$lengths = explode(',', $card['length']);
			
			foreach ($prefixes as $prefix) {
				if (preg_match('/^' . $prefix . '/', $val)) {
					foreach ($lengths as $length) {
						if (strlen($val) == $length) {
							return ($return == 'name') ? $card['name'] : $key;
						}
					}
				}
			}
		}
		
		return 'unknown';
	}
}
