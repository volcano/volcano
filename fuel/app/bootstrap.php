<?php

// Load in the Autoloader
require COREPATH.'classes'.DIRECTORY_SEPARATOR.'autoloader.php';
class_alias('Fuel\\Core\\Autoloader', 'Autoloader');

// Bootstrap the framework DO NOT edit this
require COREPATH.'bootstrap.php';

Autoloader::add_classes(array(
	// Add classes you want to override here.
	'Controller'                    => APPPATH . 'classes/controller.php',
	'Casset'                        => APPPATH . 'classes/casset.php',
	'Model'                         => APPPATH . 'classes/model.php',
	'Session'                       => APPPATH . 'classes/session.php',
	'Validation'                    => APPPATH . 'classes/validation.php',
	'Validation_Error'              => APPPATH . 'classes/validation/error.php',
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

// Redirect to setup if no sellers exist.
if (Input::server('REQUEST_URI') != '/setup') {
	$sellers = Service_Seller::find();
	if (empty($sellers)) {
		Response::redirect('setup');
	}
}
