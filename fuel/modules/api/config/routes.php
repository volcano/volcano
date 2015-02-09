<?php

return array(
	/**
	 * Seller endpoints.
	 */
	'api/sellers' => array(
		'seller.create' => array('POST', new Route('api/sellers/index')),
	),
	'api/sellers/(:num)' => array(
		'seller.get'    => array('GET', new Route('api/sellers/index/$1')),
		'seller.update' => array('PUT', new Route('api/sellers/index/$1')),
	),
	'api/sellers/(:num)/callbacks' => array(
		'seller.callback.list'   => array('GET', new Route('api/sellers/callbacks/index/$1')),
		'seller.callback.create' => array('POST', new Route('api/sellers/callbacks/index/$1')),
	),
	'api/sellers/(:num)/callbacks/(:num)' => array(
		'seller.callback.get'    => array('GET', new Route('api/sellers/callbacks/index/$1/$2')),
		'seller.callback.update' => array('PUT', new Route('api/sellers/callbacks/index/$1/$2')),
		'seller.callback.delete' => array('DELETE', new Route('api/sellers/callbacks/index/$1/$2')),
	),
	'api/sellers/(:num)/contacts' => array(
		'seller.contact.list'   => array('GET', new Route('api/sellers/contacts/index/$1')),
		'seller.contact.create' => array('POST', new Route('api/sellers/contacts/index/$1')),
	),
	'api/sellers/(:num)/contacts/(:num)' => array(
		'seller.contact.get'    => array('GET', new Route('api/sellers/contacts/index/$1/$2')),
		'seller.contact.update' => array('PUT', new Route('api/sellers/contacts/index/$1/$2')),
		'seller.contact.delete' => array('DELETE', new Route('api/sellers/contacts/index/$1/$2')),
	),
	'api/sellers/(:num)/gateways' => array(
		'seller.gateway.list'   => array('GET', new Route('api/sellers/gateways/index/$1')),
		'seller.gateway.create' => array('POST', new Route('api/sellers/gateways/index/$1')),
	),
	'api/sellers/(:num)/gateways/(:num)' => array(
		'seller.gateway.get'    => array('GET', new Route('api/sellers/gateways/index/$1/$2')),
		'seller.gateway.update' => array('PUT', new Route('api/sellers/gateways/index/$1/$2')),
		'seller.gateway.delete' => array('DELETE', new Route('api/sellers/gateways/index/$1/$2')),
	),
	
	/**
	 * Customer endpoints.
	 */
	'api/customers' => array(
		'customer.list'   => array('GET', new Route('api/customers/index')),
		'customer.create' => array('POST', new Route('api/customers/index')),
	),
	'api/customers/(:num)' => array(
		'customer.get'    => array('GET', new Route('api/customers/index/$1')),
		'customer.update' => array('PUT', new Route('api/customers/index/$1')),
		'customer.delete' => array('DELETE', new Route('api/customers/index/$1')),
	),
	'api/customers/(:num)/contacts' => array(
		'customer.contact.list'   => array('GET', new Route('api/customers/contacts/index/$1')),
		'customer.contact.create' => array('POST', new Route('api/customers/contacts/index/$1')),
	),
	'api/customers/(:num)/contacts/(:num)' => array(
		'customer.contact.get'    => array('GET', new Route('api/customers/contacts/index/$1/$2')),
		'customer.contact.update' => array('PUT', new Route('api/customers/contacts/index/$1/$2')),
		'customer.contact.delete' => array('DELETE', new Route('api/customers/contacts/index/$1/$2')),
	),
	'api/customers/(:num)/orders' => array(
		'customer.order.list'   => array('GET', new Route('api/customers/orders/index/$1')),
		'customer.order.create' => array('POST', new Route('api/customers/orders/index/$1')),
	),
	'api/customers/(:num)/orders/(:num)' => array(
		'customer.order.get' => array('GET', new Route('api/customers/orders/index/$1/$2')),
	),
	'api/customers/(:num)/paymentmethods' => array(
		'customer.paymentmethod.list'   => array('GET', new Route('api/customers/paymentmethods/index/$1')),
		'customer.paymentmethod.create' => array('POST', new Route('api/customers/paymentmethods/index/$1')),
	),
	'api/customers/(:num)/paymentmethods/(:num)' => array(
		'customer.paymentmethod.get'    => array('GET', new Route('api/customers/paymentmethods/index/$1/$2')),
		'customer.paymentmethod.update' => array('PUT', new Route('api/customers/paymentmethods/index/$1/$2')),
		'customer.paymentmethod.delete' => array('DELETE', new Route('api/customers/paymentmethods/index/$1/$2')),
	),
	'api/customers/(:num)/products' => array(
		'customer.product.list' => array('GET', new Route('api/customers/products/index/$1')),
	),
	'api/customers/(:num)/products/(:num)' => array(
		'customer.product.get' => array('GET', new Route('api/customers/products/index/$1/$2')),
	),
	'api/customers/(:num)/transactions' => array(
		'customer.transaction.list' => array('GET', new Route('api/customers/transactions/index/$1')),
	),
	'api/customers/(:num)/transactions/(:num)' => array(
		'customer.transaction.get' => array('GET', new Route('api/customers/transactions/index/$1/$2')),
	),
	'api/customers/statistics/(:alpha)' => array(
		'customer.statistic.activity.list'   => array('GET', new Route('api/customers/statistics/$1')),
		'customer.statistic.conversion.list' => array('GET', new Route('api/customers/statistics/$1')),
		'customer.statistic.totals.list'     => array('GET', new Route('api/customers/statistics/$1')),
	),
	
	/**
	 * Product endpoints.
	 */
	'api/products' => array(
		'product.list'   => array('GET', new Route('api/products/index')),
		'product.create' => array('POST', new Route('api/products/index')),
	),
	'api/products/(:num)' => array(
		'product.get'    => array('GET', new Route('api/products/index/$1')),
		'product.update' => array('PUT', new Route('api/products/index/$1')),
		'product.delete' => array('DELETE', new Route('api/products/index/$1')),
	),
	'api/products/(:num)/metas' => array(
		'product.meta.list'   => array('GET', new Route('api/products/metas/index/$1')),
		'product.meta.create' => array('POST', new Route('api/products/metas/index/$1')),
	),
	'api/products/(:num)/metas/(:num)' => array(
		'product.meta.get'    => array('GET', new Route('api/products/metas/index/$1/$2')),
		'product.meta.update' => array('PUT', new Route('api/products/metas/index/$1/$2')),
	),
	'api/products/(:num)/metas/(:num)/options' => array(
		'product.meta.option.list'   => array('GET', new Route('api/products/metas/options/index/$2')),
		'product.meta.option.create' => array('POST', new Route('api/products/metas/options/index/$2')),
	),
	'api/products/(:num)/metas/(:num)/options/(:num)' => array(
		'product.meta.option.get'    => array('GET', new Route('api/products/metas/options/index/$2/$3')),
		'product.meta.option.update' => array('PUT', new Route('api/products/metas/options/index/$2/$3')),
	),
	'api/products/(:num)/options' => array(
		'product.option.list'   => array('GET', new Route('api/products/options/index/$1')),
		'product.option.create' => array('POST', new Route('api/products/options/index/$1')),
	),
	'api/products/(:num)/options/(:num)' => array(
		'product.option.get'    => array('GET', new Route('api/products/options/index/$1/$2')),
		'product.option.update' => array('PUT', new Route('api/products/options/index/$1/$2')),
		'product.option.delete' => array('DELETE', new Route('api/products/options/index/$1/$2')),
	),
	'api/products/(:num)/options/(:num)/fees' => array(
		'product.option.fee.list'   => array('GET', new Route('api/products/options/fees/index/$2')),
		'product.option.fee.create' => array('POST', new Route('api/products/options/fees/index/$2')),
	),
	'api/products/(:num)/options/(:num)/fees/(:num)' => array(
		'product.option.fee.get'    => array('GET', new Route('api/products/options/fees/index/$2/$3')),
		'product.option.fee.update' => array('PUT', new Route('api/products/options/fees/index/$2/$3')),
		'product.option.fee.delete' => array('DELETE', new Route('api/products/options/fees/index/$2/$3')),
	),
	
	/**
	 * API endpoints.
	 */
	'api/endpoints' => array(
		'endpoint.list' => array('GET', new Route('api/endpoints/index')),
	),
);
