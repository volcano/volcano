<?php

/**
 * Base inflector class.
 */
class Inflector extends \Fuel\Core\Inflector
{
	/**
	 * Takes an underscore or dash separated word and turns it into a human looking title.
	 *
	 * @param string $string    The string to titleize.
	 * @param string $separator The separator (either _ or -).
	 * @param bool   $ucwords   Whether or not to capitalize the first letter of every word.
	 * 
	 * @return string
	 */
	public static function titleize($string, $separator = '_', $ucwords = true)
	{
		$string = str_replace($separator, ' ', strval($string));
		
		if ($ucwords) {
			$string = Str::ucwords($string);
		}
		
		return $string;
	}
}
