<?php

/**
 * View helper class.
 */
class View_Helper
{
	/**
	 * Prints an alert list for the given type.
	 *
	 * @param array $type    The type of alerts to show.
	 * @param array $options Options to use for alerts.
	 * 
	 * @return View
	 */
	public static function alerts($type = 'all', array $options = array())
	{
		$alerts = array();
		
		if ($type == 'all') {
			$alerts['success'] = Session::get_flash('alert.success');
			$alerts['info']    = Session::get_flash('alert.info');
			$alerts['error']   = Session::get_flash('alert.error');
		} else {
			$alerts[$type] = Session::get_flash('alert.' . $type);
		}
		
		Session::delete_flash('alert');
		
		return View::forge('common/alerts', array(
			'type'    => $type,
			'alerts'  => $alerts,
			'options' => $options,
		));
	}
	
	/**
	 * Prints a navigation list with the given items.
	 *
	 * @param array $items   The navigation items for links.
	 * @param array $options Options to use for nav.
	 * 
	 * @return View
	 */
	public static function nav($items = array(), array $options = array())
	{
		return View::forge('common/navigation', array(
			'items'   => $items,
			'options' => $options,
		));
	}
	
	/**
	 * Prints breadcrumbs with the given items.
	 *
	 * @param array $breadcrumbs The breadcrumbs to display.
	 * @param array $options     Options to use for nav.
	 * 
	 * @return View
	 */
	public static function breadcrumbs($breadcrumbs = array(), array $options = array())
	{
		return View::forge('common/breadcrumbs', array(
			'breadcrumbs' => $breadcrumbs,
			'options'     => $options,
		));
	}
	
	/**
	 * Return the formatted date.
	 *
	 * @param string $date        The date to format.
	 * @param string $default     The default string to return.
	 * @param string $to_format   The date format to convert to.
	 * @param string $from_format The date format to convert from.
	 *
	 * @return string|null
	 */
	public static function date($date, $default = null, $to_format = 'us', $from_format = 'mysql')
	{
		if ($from_format == 'mysql' && $date == '0000-00-00 00:00:00') {
			return $default;
		}
		
		if (empty($date)) {
			return $default;
		}
		
		if (!$date instanceof Date) {
			$date = Date::create_from_string($date, $from_format);
		}
		
		return '<abbr title="' . $date->format('us_full') . '">' . $date->format($to_format) . '</abbr>';
	}
}
