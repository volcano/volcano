<?php

return array(
	/*
	| What format should the data be returned in by default?
	|
	|	Default: xml
	|
	*/
	'default_format' => 'json',
	
	/*
	| Is login required and if so, which type of login?
	|
	|	'' = no login required,
	| 'basic' = unsecure login,
	| 'digest' = more secure login
	| or define a method name in your REST controller that handles authorization
	|
	*/
	'auth' => '_prepare_key_auth',
	
	/*
	| Ignore HTTP_ACCEPT
	|
	| A lot of work can go into detecting incoming data,
	| disabling this will speed up your requests if you do not use a ACCEPT header.
	|
	*/
	'ignore_http_accept' => true,
);
