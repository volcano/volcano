<?php

return array(
	/**
	 * An array of paths that will be searched for lesscss assets.
	 * You should probably keep them out of public access
	 * This MUST include the trailing slash ('/')
	 *
	 * Default: APPPATH.'vendor/less/'
	 */
	'source_dir' => DOCROOT.'assets/',
	
	/**
	 * As the asset config is a array with multiple paths, you must tell
	 * what is the default path where the compiled less files will be
	 * The value means the key of asset.paths that will be used
	 *
	 * This MUST include the trailing slash ('/')
	 *
	 * Default: Config::get('asset.paths.0').Config::get('asset.css_dir'),
	 */
	'output_dir' => Casset::get_cache_path(),
	
	/**
	 * Path key for assets if using Casset.
	 * 
	 * Default: false
	 */
	'casset_path_key' => 'cache',
);
