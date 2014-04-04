![Volcano Logo](https://raw.githubusercontent.com/volcano/billing/master/public/assets/img/logo-large.png)

# Volcano - Billing

## Introduction

Volcano is an API-first billing solution that is capable of interfacing with [a variety of payment gateways](#gateways). Volcano offers both a robust, RESTful API as well as a fully-featured front-end control panel.

## Mission
Volcano is meant to be a flexible, gateway-agnostic billing system. The system can be setup with one or more sellers, each of which has its own set of configurable products and customer base. Volcano's core elements include sellers, customers, products, product options, product fees, orders and transactions. Current goals for the project include additional features for these core elements and new light-weight CRM tools such as customer support ticket management.

## Design
Volcano is built on top of the [FuelPHP](http://fuelphp.com) framework. The app is designed with [multitenancy](http://en.wikipedia.org/wiki/Multitenancy) in mind and heavily leverages the [adapter pattern](http://en.wikipedia.org/wiki/Adapter_pattern) for multi-gateway support and the [service pattern](http://en.wikipedia.org/wiki/Service_layers_pattern) for the core structure that powers both the API and front-end control panel. Additionally, both the API and control panel use the same core validation classes.

Volcano supports event-based callbacks. For example, Volcano can POST data to an external callback URL when a new customer is created. This allows 3rd party apps to handle their own email product messaging and feature ACL. Event callbacks can be setup via the API or control panel Settings page.

## Installation

First, ensure that your system meets [FuelPHP's minimum requirements](http://fuelphp.com/docs/requirements.html).


Next, clone the repo:

	$ git clone -b master https://github.com/volcano/billing.git volcano

Initialize all submodules:

	$ cd volcano && git submodule update --init --recursive

Install [Composer](https://getcomposer.org/doc/00-intro.md).

Install Composer dependencies:

	$ php composer.phar install

## Configuration

#### App
Create a new database.

Add these new database credentials to the appropriate database environment config(s) (`fuel/app/config/[ENVIRONMENT]/db.php`).

Run the __setup__ [task](http://fuelphp.com/docs/packages/oil/refine.html) (sets file permissions and runs migrations):

	$ php oil r setup

Setup the __statistics__ and __recurring__ tasks as [crons](http://en.wikipedia.org/wiki/Cron#Examples) that run every night. Something like this:

	$ 00 00 * * * FUEL_ENV=production /usr/bin/php oil r recurring
	$ 00 01 * * * FUEL_ENV=production /usr/bin/php oil r statistics

Optional: Run the __simulate__ task to auto-generate faux seller, product, customer and order data. This will allow you to more easily test out various control panel features. Run the __statistics__ task to compute stats for the simulated data.

	$ php oil r simulate
	$ php oil r statistics

#### API
For API development and testing, you'll want to first create a seller (see "Usage" below) and then create an API key via the Settings tab in the control panel.

Next, copy the new seller API key and add it to `fuel/app/config/development/api.php` so that you don't have to specify the api_key param when testing locally.

##Usage

#### App
You'll be redirected to `[YOUR DOMAIN]/setup` the first time you access the Volcano control panel. This will allow you to create your first Seller. You may access `[YOUR DOMAIN]/setup` at any time to easily create additional sellers.

#### API
Listed below are a few example API calls (using [HTTPie](http://httpie.org)).

Create a Product:

	$ http -f POST volcano.dev/api/products/71687/options name="Product ABC"

Create a Customer:

	$ http -f POST volcano.dev/api/customers contact[first_name]=Scatman contact[last_name]=John contact[email]=imthescatman@scatman.com

Create a Multi-Product Order for a Customer:

	$ http -f POST volcano.dev/api/customers/120488428/orders products[4]="myappdomain.com" products[7]="My App Instance"


## Contributing

#### General Changes
1. [Fork the repository](https://help.github.com/articles/fork-a-repo)
2. [Create a topic branch](http://learn.github.com/p/branching.html)
3. [Add, commit and push your changes](http://git-scm.com/book/en/Git-Basics-Getting-a-Git-Repository)
4. [Submit a pull request](https://help.github.com/articles/using-pull-requests)

#### Payment Gateways <a name="gateways"></a>

Volcano's Payment Gateway system utilizes the [adapter design pattern](http://en.wikipedia.org/wiki/Adapter_pattern). The adapter allows the system to interface with a variety of billing drivers (Authorize.net, Stripe, PayPal, etc). Currently, Authorize.net is the only supported payment gateway. However, additional gateways can easily be added:

1. Create a new directory within `/fuel/app/classes/gateway` for the new gateway driver.
2. Within this new directory, add `driver.php`, `customer.php`, `paymentmethod.php` and `transaction.php`  files. Each of these files should contain CRUD logic specific to the new driver. Refer to the authorizenet driver as a general guide for how to name the classes and structure code.
