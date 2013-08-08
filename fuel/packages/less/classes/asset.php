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

class Asset extends \Fuel\Core\Asset
{
	/**
	 * Init the class and load the config file
	 */
	public static function _init()
	{
		parent::_init();
		
		\Config::load('less', 'asset');
	}

	/**
	 * Either adds the Less stylesheet to the group, or returns the CSS tag.
	 *
	 * @param array|string $stylesheets The file name, or an array files.
	 * @param array $attr An array of extra attributes
	 * @param string $group The asset group name
	 * @param bool $raw Whether to return the raw file or not
	 * @return object|string Rendered asset or current instance when adding to group
	 */
	public static function less($stylesheets = array(), $attr = array(), $group = NULL, $raw = false)
	{
		return static::instance()->less($stylesheets, $attr, $group, $raw);
	}
}
