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
	| Ignore HTTP_ACCEPT
	|
	| A lot of work can go into detecting incoming data,
	| disabling this will speed up your requests if you do not use a ACCEPT header.
	|
	*/
	'ignore_http_accept' => true,
);
