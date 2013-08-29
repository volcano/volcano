<?php

/**
 * Base inflector class.
 *
 * @author Daniel Sposito <dsposito@static.com>
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
		// Allow dash, otherwise default to underscore.
		$separator = $separator != '-' ? '_' : $separator;
		
		if ($ucwords) {
			$string = Str::ucwords($string);
		}
		
		return str_replace($separator, ' ', strval($string));
	}
}
