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

Autoloader::add_core_namespace('Less');

Autoloader::add_classes(array(
	'Less\\Less'           => __DIR__.'/classes/less.php',
	'Less\\LessException'  => __DIR__.'/classes/less.php',
	'Less\\Asset'          => __DIR__.'/classes/asset.php',
	'Less\\Asset_Instance' => __DIR__.'/classes/asset/instance.php',
	'Less\\Casset'         => __DIR__.'/classes/casset.php',
));