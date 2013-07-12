<?php
/**
 * Use this file to override global defaults.
 *
 * See the individual environment DB configs for specific config information.
 */

return array(
	'active' => 'default',
	
	/**
	 * Base config.
	 */
	'default' => array(
		'type'        => 'pdo',
		'identifier'   => '`',
		'table_prefix' => '',
		'charset'      => 'utf8',
		'enable_cache' => false,
		'profiling'    => true,
	),
);
