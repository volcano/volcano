<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2012 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * FuelPHP LessCSS package implementation. This namespace controls all Google
 * package functionality, including multiple sub-namespaces for the various
 * tools.
 *
 * @author     Kriansa
 * @version    1.0
 * @package    Fuel
 * @subpackage Less
 */
namespace Less;

class Casset extends \Casset\Casset
{
	
	/**
	 * Less
	 *
	 * Compile a less file and add css asset.
	 *
	 * @param string $sheet The script to add
	 * @param string $sheet_min If given, will be used when $min = true
	 *        If omitted, $script will be minified internally
	 * @param string $group The group to add this asset to. Defaults to 'global'
	 */
	public static function less($sheet, $sheet_min = false, $group = 'global')
	{
		$sheet = (array) $sheet;

		\Less::compile($sheet);

		foreach ($sheet as $sheet_file) {
			if (!\Config::get('less.keep_dir', true)) {
				$sheet_hash = md5($sheet_file);
				$sheet_file = pathinfo($sheet_file, PATHINFO_FILENAME);
				
				if (\Config::get('less.hash_filename', true)) {
					$sheet_file .= '-'.$sheet_hash;
				}
				
				$sheet_file .= '.css';
			}

			static::css($sheet_file, $sheet_min, $group);
		}
	}
	
}
