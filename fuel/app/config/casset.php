<?php

return array(
	/**
	 * An array of paths that will be searched for assets.
	 * Each path is assigned a name, which is used when referring to that asset.
	 * See the js() and css() docs for more info.
	 * Each asset is a RELATIVE path from the base_url WITH a trailing slash.
	 * There must be an entry with the key 'core'. This is used when no path
	 * is specified.
	 *
	 * array(
	 *		'core' => 'assets/'
	 * )
	 *
	 * You can also choose to override the js_dir, css_dir and/or img_dir config
	 * options on a per-path basis. You can override just one dir, two, or all
	 * of them.
	 * In this case, the syntax is
	 * array (
	 *		'some_key' => array(
	 *			'path' => 'more_assets/',
	 *			'js_dir' => 'javascript/',
	 *			'css_dir' => 'styles/'
	 *			'img_dir' => 'images/',
	 *		),
	 * )
	 */
	'paths' => array(
		'core' => array(
			'path'    => Config::get('asset.paths.0'),
			'js_dir'  => Config::get('asset.js_dir'),
			'css_dir' => Config::get('asset.css_dir'),
			'img_dir' => Config::get('asset.img_dir'),
		)
	),
	
	/**
	 * Asset Sub-folders
	 *
	 * Names for the js and css folders (inside the asset path).
	 *
	 * Examples:
	 *
	 * js/
	 * css/
	 * img/
	 *
	 * This MUST include the trailing slash ('/')
	 */
	'js_dir'  => Config::get('asset.js_dir'),
	'css_dir' => Config::get('asset.css_dir'),
	'img_dir' => Config::get('asset.img_dir'),

	/**
	 * Whether to minify files.
	 */
	'min' => false,

	/**
	 * Whether to combine files
	 */
	'combine' => false,
);
