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
	
	/**
	 * Converts a string, delimited by periods or underscores, to lowerCamelCase.
	 *
	 * @param string The delimited string.
	 * 
	 * @return string The lowerCamelCased version of $delimited_string.
	 */
	public static function lower_camelize($delimited_string)
	{
		$string = preg_replace_callback(
			'/(^|[\._])(.)/',
			function ($parm) {
				return strtoupper($parm[2]);
			},
			strval($delimited_string)
		);
		
		return lcfirst($string);
	}
}
