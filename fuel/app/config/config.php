<?php

return array(
	'profiling' => Input::get('profile', false),
	
	/**
	 * DateTime settings
	 *
	 * server_gmt_offset	in seconds the server offset from gmt timestamp when time() is used
	 * default_timezone		optional, if you want to change the server's default timezone
	 */
	// 'server_gmt_offset'  => 0,
	'default_timezone' => 'America/Chicago',
	
	/**
	 * Security settings
	 */
	'security' => array(
		'db_enc_key'     => 'MZx63AzdEzjdw6EtFvfoyM1kvqXF1p9w',
		'csrf_token_key' => 'WlC4g7OqeyJZb0syMg8OYMa1bEGF2d7r',
		
		/**
		 * This input filter can be any normal PHP function as well as 'xss_clean'
		 *
		 * WARNING: Using xss_clean will cause a performance hit.
		 * How much is dependant on how much input data there is.
		 *
		 * Note: MUST BE DEFINED IN THE APP CONFIG FILE!
		 */
		'uri_filter' => array(),
		
		/**
		 * This input filter can be any normal PHP function as well as 'xss_clean'
		 *
		 * WARNING: Using xss_clean will cause a performance hit.
		 * How much is dependant on how much input data there is.
		 *
		 * Note: MUST BE DEFINED IN THE APP CONFIG FILE!
		 */
		'input_filter' => array(),
		
		/**
		 * This output filter can be any normal PHP function as well as 'xss_clean'
		 *
		 * WARNING: Using xss_clean will cause a performance hit.
		 * How much is dependant on how much input data there is.
		 *
		 * Note: MUST BE DEFINED IN THE APP CONFIG FILE!
		 */
		'output_filter' => array(),
		
		/**
		 * Whether to automatically filter view data
		 */
		'auto_filter_output' => false,
	),
	
	/**
	 * To enable you to split up your application into modules which can be
	 * routed by the first uri segment you have to define their basepaths
	 * here. By default empty, but to use them you can add something
	 * like this:
	 *      array(APPPATH.'modules'.DS)
	 *
	 * Paths MUST end with a directory separator (the DS constant)!
	 */
	'module_paths' => array(
		APPPATH . '..' . DS . 'modules' . DS
	),
	
	/**
	 * To enable you to split up your additions to the framework, packages are
	 * used. You can define the basepaths for your packages here. By default
	 * empty, but to use them you can add something like this:
	 *      array(APPPATH.'modules'.DS)
	 *
	 * Paths MUST end with a directory separator (the DS constant)!
	 */
	'package_paths' => array(
		PKGPATH
	),
	
	/**************************************************************************/
	/* Always Load                                                            */
	/**************************************************************************/
	'always_load' => array(
		/**
		 * These packages are loaded on Fuel's startup.
		 * You can specify them in the following manner:
		 *
		 * array('auth'); // This will assume the packages are in PKGPATH
		 *
		 * // Use this format to specify the path to the package explicitly
		 * array(
		 *     array('auth'	=> PKGPATH.'auth/')
		 * );
		 */
		'packages' => array(
			'orm',
			'authorizenet',
		),
		
		/**
		 * These modules are always loaded on Fuel's startup. You can specify them
		 * in the following manner:
		 *
		 * array('module_name');
		 *
		 * A path must be set in module_paths for this to work.
		 */
		'modules' => array(
			'api',
		),
	),
);
