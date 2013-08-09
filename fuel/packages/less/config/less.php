<?php
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
	'source_dir' => APPPATH.'vendor/less/',
	
	/**
	 * As the asset config is a array with multiple paths, you must tell
	 * what is the default path where the compiled less files will be
	 * The value means the key of asset.paths that will be used
	 * 
	 * This MUST include the trailing slash ('/')
	 *
	 * Default: Config::get('asset.paths.0').Config::get('asset.css_dir'),
	 */
	'output_dir' => Config::get('asset.paths.0').Config::get('asset.css_dir'),

	/**
	 * Whether or not to keep the directory that the file is in or just
	 * store in the main output_dir.
	 *
	 * Default: true
	 */
	'keep_dir' => true,

	/**
	 * Whether or not to to hash the filename of the less compiled file.
	 *
	 * Default: false
	 */
	'hash_filename' => false,
);
