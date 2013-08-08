<?php
/**
 * FuelPHP LessCSS package implementation.
 *
 * @author     Kriansa
 * @version    2.0
 * @package    Fuel
 * @subpackage Less
 */

/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */

return array(

	/**
	 * An array of paths that will be searched for lesscss assets.
	 * You should probably keep them out of public access
	 * This MUST include the trailing slash ('/')
	 *
	 * Default: APPPATH.'vendor/less/'
	 */
	'less_source_dir' => APPPATH.'vendor/less/',
	
	/**
	 * As the asset config is a array with multiple paths, you must tell
	 * what is the default path where the compiled less files will be
	 * The value means the key of asset.paths that will be used
	 * 
	 * This MUST include the trailing slash ('/')
	 *
	 * Default: DOCROOT.Config::get('asset.paths.0').Config::get('asset.css_dir'),
	 */
	'less_output_dir' => DOCROOT.Config::get('asset.paths.0').Config::get('asset.css_dir'),

	/**
	 * Class to compile less files
	 * You can create your own driver if you want
	 */
	'less_compiler' => 'Less\\Compiler_Node'
);
