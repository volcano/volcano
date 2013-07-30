<?php

return array(
	// Allows the index action to not have to be in the URL.
	'api/(:segment)/(:num)'                                     => 'api/$1/index/$2',
	
	'api/(:segment)/(:num)/(:segment)'                          => 'api/$1/$3/index/$2',
	'api/(:segment)/(:num)/(:segment)/(:num)'                   => 'api/$1/$3/index/$2/$4',
	
	'api/(:segment)/(:num)/(:segment)/(:num)/(:segment)'        => 'api/$1/$3/$5/index/$4',
	'api/(:segment)/(:num)/(:segment)/(:num)/(:segment)/(:num)' => 'api/$1/$3/$5/index/$4/$6',
);
