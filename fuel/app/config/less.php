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
	'output_dir' => Casset::$cache_path,
	
	/**
	 * Whether or not to keep the directory that the file is in or just
	 * store in the main output_dir.
	 *
	 * Default: true
	 */
	'keep_dir' => false,
	
	/**
	 * Whether or not to to hash the filename of the less compiled file.
	 *
	 * Default: false
	 */
	'hash_filename' => true,
);
