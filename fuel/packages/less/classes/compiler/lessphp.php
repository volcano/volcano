<?php
/**
 * FuelPHP LessCSS package implementation.
 *
 * @author     Kriansa
 * @version    2.0
 * @package    Fuel
 * @subpackage Less
 */
namespace Less;

class Compiler_Lessphp
{
	/**
	 * Init the class
	 */
	public static function _init()
	{
		require_once PKGPATH.'less'.DS.'vendor'.DS.'lessphp'.DS.'lessc.inc.php';
	}

	/**
	 * Compile the Less file in $origin to the CSS $destination file
	 *
	 * @param string $origin Input Less path
	 * @param string $destination Output CSS path
	 */
	public static function compile($origin, $destination)
	{
		$less = new \lessc;
		$less->indentChar = \Config::get('asset.indent_with');
		$less->setImportDir(array(dirname($origin), dirname($destination)));
		$raw_css = $less->compile(file_get_contents($origin));

		$destination = pathinfo($destination);
		\File::update($destination['dirname'], $destination['basename'], $raw_css);
	}
}
