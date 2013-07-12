<?php

return array(
	// Allows the index action to not have to be in the URL.
	'api/(:segment)/(:num)' => 'api/$1/index/$2',
);
