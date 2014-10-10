<?php

$prefix = 'api';

return array(
	/**
	 * Seller endpoints.
	 */
	$prefix . '/sellers/(:num)'                  => $prefix . '/sellers/index/$1',
	$prefix . '/sellers/(:num)/callbacks'        => $prefix . '/sellers/callbacks/index/$1',
	$prefix . '/sellers/(:num)/callbacks/(:num)' => $prefix . '/sellers/callbacks/index/$1/$2',
	$prefix . '/sellers/(:num)/contacts'         => $prefix . '/sellers/contacts/index/$1',
	$prefix . '/sellers/(:num)/contacts/(:num)'  => $prefix . '/sellers/contacts/index/$1/$2',
	$prefix . '/sellers/(:num)/gateways'         => $prefix . '/sellers/gateways/index/$1',
	$prefix . '/sellers/(:num)/gateways/(:num)'  => $prefix . '/sellers/gateways/index/$1/$2',
	
	/**
	 * Customer endpoints.
	 */
	$prefix . '/customers'                              => $prefix . '/customers/index',
	$prefix . '/customers/(:num)'                       => $prefix . '/customers/index/$1',
	$prefix . '/customers/(:num)/contacts'              => $prefix . '/customers/contacts/index/$1',
	$prefix . '/customers/(:num)/contacts/(:num)'       => $prefix . '/customers/contacts/index/$1/$2',
	$prefix . '/customers/(:num)/orders'                => $prefix . '/customers/orders/index/$1',
	$prefix . '/customers/(:num)/orders/(:num)'         => $prefix . '/customers/orders/index/$1/$2',
	$prefix . '/customers/(:num)/paymentmethods'        => $prefix . '/customers/paymentmethods/index/$1',
	$prefix . '/customers/(:num)/paymentmethods/(:num)' => $prefix . '/customers/paymentmethods/index/$1/$2',
	$prefix . '/customers/(:num)/products'              => $prefix . '/customers/products/index/$1',
	$prefix . '/customers/(:num)/products/(:num)'       => $prefix . '/customers/products/index/$1/$2',
	$prefix . '/customers/(:num)/statistics'            => $prefix . '/customers/statistics/index/$1',
	$prefix . '/customers/(:num)/statistics/(:num)'     => $prefix . '/customers/statistics/index/$1/$2',
	$prefix . '/customers/(:num)/transactions'          => $prefix . '/customers/transactions/index/$1',
	$prefix . '/customers/(:num)/transactions/(:num)'   => $prefix . '/customers/transactions/index/$1/$2',
	
	/**
	 * Product endpoints.
	 */
	$prefix . '/products'                                   => $prefix . '/products/index',
	$prefix . '/products/(:num)'                            => $prefix . '/products/index/$1',
	$prefix . '/products/(:num)/options'                    => $prefix . '/products/options/index/$1',
	$prefix . '/products/(:num)/options/(:num)'             => $prefix . '/products/options/index/$1/$2',
	$prefix . '/products/(:num)/options/(:num)/fees'        => $prefix . '/products/options/fees/index/$1/$2',
	$prefix . '/products/(:num)/options/(:num)/fees/(:num)' => $prefix . '/products/options/fees/index/$2/$3',
	
);
