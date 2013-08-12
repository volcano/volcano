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

class Asset_Instance extends \Fuel\Core\Asset_Instance
{
	
	/**
	 * Less
	 *
	 * Compile a Less file and load it as a CSS asset.
	 *
	 * @access	public
	 * @param	mixed	       The file name, or an array files.
	 * @param	array	       An array of extra attributes
	 * @param	string	       The asset group name
	 * @return	string|object  Rendered asset or current instance when adding to group
	 */
	public function less($stylesheets = array(), $attr = array(), $group = null, $raw = false)
	{
		\Less::compile($stylesheets);
		
		return static::css($stylesheets, $attr, $group, $raw);
	}
	
}