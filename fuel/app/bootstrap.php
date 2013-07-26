<?php

// Load in the Autoloader
require COREPATH.'classes'.DIRECTORY_SEPARATOR.'autoloader.php';
class_alias('Fuel\\Core\\Autoloader', 'Autoloader');

// Bootstrap the framework DO NOT edit this
require COREPATH.'bootstrap.php';


Autoloader::add_classes(array(
	// Add classes you want to override here.
	'Controller'                    => APPPATH . 'classes/controller.php',
	'Model'                         => APPPATH . 'classes/model.php',
	'Validation'                    => APPPATH . 'classes/validation.php',
	'Api\\HttpErrorException'       => APPPATH . '../modules/api/classes/httpexceptions.php',
	'Api\\HttpBadRequestException'  => APPPATH . '../modules/api/classes/httpexceptions.php',
	'Api\\HttpNotFoundException'    => APPPATH . '../modules/api/classes/httpexceptions.php',
	'Api\\HttpServerErrorException' => APPPATH . '../modules/api/classes/httpexceptions.php',
));

// Register the autoloader
Autoloader::register();

/**
 * Your environment.  Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGING
 * Fuel::PRODUCTION
 */
Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : Fuel::DEVELOPMENT);

// Initialize the framework with the config file.
Fuel::init('config.php');

// Load the app helper functions.
require APPPATH . 'app.php';
