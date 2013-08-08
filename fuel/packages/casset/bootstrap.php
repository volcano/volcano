<?php

/**
 * Casset: Convenient asset library for FuelPHP.
 *
 * @package    Casset
 * @version    v1.21
 * @author     Antony Male
 * @license    MIT License
 * @copyright  2013 Antony Male
 * @link       http://github.com/canton7/fuelphp-casset
 */


Autoloader::add_core_namespace('Casset');

Autoloader::add_classes(array(
	'Casset\\Casset'                => __DIR__.'/classes/casset.php',
	'Casset\\Casset_JSMin'          => __DIR__.'/classes/casset/jsmin.php',
	'Casset\\Casset_Csscompressor'  => __DIR__.'/classes/casset/csscompressor.php',
	'Casset\\Casset_Cssurirewriter' => __DIR__.'/classes/casset/cssurirewriter.php',
	'Casset\\Casset_Cssurirewriterrelative' => __DIR__.'/classes/casset/cssurirewriterrelative.php',
	'Casset\\Casset_Addons_Twig'    => __DIR__.'/classes/casset/addons/twig.php',
));

/* End of file bootstrap.php */
