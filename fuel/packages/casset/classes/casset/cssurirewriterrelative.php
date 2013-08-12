<?php

/**
 * This library is used as part of Casset.
 *
 * @package    Casset
 * @version    v1.21
 * @author     Antony Male
 * @license    MIT License
 * @link       http://github.com/canton7/fuelphp-casset
 */

namespace Casset;

class Casset_Cssurirewriterrelative {
	const PATTERN = '/(url|@import)\s*\(\s*([\'"]?)([^\/\'"][^)\2]+)\2\s*\)/';

	public static function rewrite_css($css, $before_dir, $after_dir) {
		// Normalise slashes
		$before_dir = str_replace('\\', '/', $before_dir);
		$after_dir = str_replace('\\', '/', $after_dir);

		// Make sure before_dir and after_dir have trailing slashes
		$before_dir = rtrim($before_dir, '/') . '/';
		$after_dir = rtrim($after_dir, '/') . '/';

		// Trim off common leading prefix
		$i = 0;
		for (; $i<strlen($after_dir); $i++) {
			if ($after_dir[$i] != $before_dir[$i])
				break;
		}
		// If we quit on the first loop, $i holds first index of mismatch, otherwise last index of match
		$i = max($i-1, 0);
		$after_dir = substr($after_dir, $i);
		$before_dir = substr($before_dir, $i);

		// Move back out of the dir that the file ends up in
		// then back into the dir the file was in before
		$rel = str_repeat('../', substr_count($after_dir, '/')) . $before_dir;

		$css = preg_replace_callback(static::PATTERN, function($m) use ($rel) {
			list($match, $type, $quote, $url) = $m;
			if (strpos($url, 'data:') === 0 || strpos($url, '://') !== false)
				return $match;
			// PHP anonymous function binding fail
			$rel_url = Casset_Cssurirewriterrelative::tidy_url("$rel$url");
			return "$type($quote$rel_url$quote)";
		}, $css);

		return $css;
	}

	public static function tidy_url($url) {
		// Get rid of /./ and something/../
		$url = preg_replace('#(/|^)\./#', '\1', $url);

		do {
			$url = preg_replace('#(/|^)[^/\.]+/\.\./#', '\1', $url, -1, $changed);
		} while ($changed);

		return $url;
	}
}

/* End of file casset/cssurirewriterrelative.php */
