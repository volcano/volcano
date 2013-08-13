<?php

/**
 * Validation error class.
 *
 * @author Derek Myers <dmyers@static.com>
 */
class Validation_Error extends \Fuel\Core\Validation_Error
{
	public function get_message($msg = false, $open = '', $close = '')
	{
		if (empty($open) && empty($close)) {
			$open = '<span class="help-inline">';
			$close = '</span>';
		}
		
		return parent::get_message($msg, $open, $close);
	}
}
