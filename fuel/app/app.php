<?php

/**
 * Application helper functions.
 */

/**
 * Debug helper function.
 *
 * @return void
 */
if (!function_exists('dump')) {
	function dump() {
		$args = (array) func_get_args();
		
		foreach ($args as $arg) {
			Debug::dump($arg);
		}
	}
}

/**
 * Pretty print debug helper function.
 *
 * @return void
 */
if (!function_exists('dar')) {
	function dar() {
		$args = (array) func_get_args();
		
		foreach ($args as $arg) {
			echo '<pre class="dar">';
				print_r($arg);
			echo '</pre>';
		}
	}
}
