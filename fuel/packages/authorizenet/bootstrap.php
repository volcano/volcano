<?php

require_once __DIR__ . DS . 'vendor' . DS . 'authorizenet-sdk' . DS . 'AuthorizeNet.php';

Autoloader::add_core_namespace('AuthorizeNet');

Autoloader::add_classes(array(
	'AuthorizeNet\\AuthorizeNet'          => __DIR__.'/classes/authorizenet.php',
	'AuthorizeNet\\AuthorizeNetException' => __DIR__.'/classes/authorizenet.php',
));
