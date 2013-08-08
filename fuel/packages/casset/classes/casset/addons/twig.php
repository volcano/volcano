<?php

/**
 * Casset: Convenient asset library for FuelPHP.
 *
 * @package    Casset
 * @version    v1.21
 * @author     Antony Male
 * @author     Derek Myers
 * @license    MIT License
 * @copyright  2013 Antony Male
 * @link       http://github.com/canton7/fuelphp-casset
 */

namespace Casset;

class Casset_Addons_Twig extends \Twig_Extension
{
	/**
	 * Gets the name of the extension.
	 *
	 * @return  string
	 */
	public function getName()
	{
		return 'casset';
	}

	/**
	 * Sets up all of the functions this extension makes available.
	 *
	 * @return  array
	 */
	public function getFunctions()
	{
		return array(
			'render_assets' => new \Twig_Function_Function('Casset::render'),
			'render_css'    => new \Twig_Function_Function('Casset::render_css'),
			'render_js'     => new \Twig_Function_Function('Casset::render_js'),
			'img'           => new \Twig_Function_Function('Casset::img'),
			'img_url'       => new \Twig_Function_Function('Casset::get_filepath_img'),
			'add_css'       => new \Twig_Function_Function('Casset::css'),
			'add_js'        => new \Twig_Function_Function('Casset::js'),
		);
	}
}

/* End of file twig.php */
