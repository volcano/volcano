<?php
return array(
	// Default route.
	'_root_'  => 'dashboard',
	
	// Error route.
	'_404_'   => 'error/404',
	
	'(:segment)/(:num)/(:segment)' => '$1/$3/index/$2',
);
