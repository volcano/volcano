<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2012 Fuel Development Team
 * @link       http://fuelphp.com
 */

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
namespace Less;

class Less
{

	/**
	 * Initialize by loading config
	 */
	public static function _init()
	{
		\Config::load('asset', true);
		\Config::load('less', true);
	}
	
	/**
	 * Compile
	 *
	 * Compiles the less files.
	 *
	 * @access	public
	 * @param	mixed	The file name, or an array files.
	 * @return	string
	 */
	public static function compile($stylesheets = array())
	{
		if ( ! is_array($stylesheets))
		{
			$stylesheets = array($stylesheets);
		}
		
		foreach($stylesheets as &$lessfile)
		{
			$source_less  = \Config::get('less.source_dir').$lessfile;
			
			if( ! is_file($source_less))
			{
				throw new \LessException('Could not find less source file: '.$source_less);
			}
			
			// Change the name for loading with Asset::css
			$lessfile_original = $lessfile;
			$lessfile = str_replace('.'.pathinfo($lessfile, PATHINFO_EXTENSION), '', $lessfile).'.css';

			$output_dir = \Config::get('less.output_dir');
			
			if (\Config::get('less.keep_dir', true)) {
				// Full path to css compiled file
				$compiled_css = $output_dir.$lessfile;
			} else {
				$compile_hash = md5($lessfile_original);
				$compile_name = pathinfo($lessfile, PATHINFO_FILENAME);
				
				if (\Config::get('less.hash_filename', true)) {
					$compile_name .= '-'.$compile_hash;
				}
				
				// Use file name of less as css in output dir.
				$compiled_css = $output_dir.$compile_name.'.css';
			}
			
			// Compile only if source is newer than compiled file
			if ( ! is_file($compiled_css) or filemtime($source_less) > filemtime($compiled_css))
			{
				require_once PKGPATH.'less'.DS.'vendor'.DS.'lessphp'.DS.'lessc.inc.php';
				
				$handle = new \lessc($source_less);
				$handle->indentChar = \Config::get('asset.indent_with');
				
				$compile_path = dirname($compiled_css);
				$css_name     = pathinfo($compiled_css, PATHINFO_BASENAME);

				\File::update($compile_path, $css_name, $handle->parse());
			}
		}

		return $stylesheets;
	}
	
}

class LessException extends \FuelException {
}
