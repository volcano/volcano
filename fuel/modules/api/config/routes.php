<?php

return array(
	// Allows the index action to not have to be in the URL.
	'api/(:segment)/(:num)'                        => 'api/$1/index/$2',
	
	'api/products/(:num)/options'                  => 'api/products/options/index/$1',
	'api/products/(:num)/options/(:num)'           => 'api/products/options/index/$1/$2',
	'api/products/:num/options/(:num)/fees'        => 'api/products/options/fees/index/$1',
	'api/products/:num/options/(:num)/fees/(:num)' => 'api/products/options/fees/index/$1/$2',
);
