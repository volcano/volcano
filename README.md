# Volcano CRM

## Introduction

This should help you get started with Volcano CRM.

## Installation
Clone the repo:

	$ git clone -b dev ssh://git@code.onesite.com/volcano/crm.git volcano

Initialize all submodules:

	$ cd volcano && git submodule update --init --recursive

Update Composer and dependencies:

	$ php composer.phar self-update
	$ php composer.phar update

## Configuration
Create a new local database.

Update the dev database config (`fuel/app/config/development/db.php`).

Set file permissions and run migrations:

	$ php oil r setup

For API development and testing, insert a new record into the api_keys table.

Copy the key you inserted and add it to `fuel/app/config/development/api.php` so that you don't have to specify the api_key param when testing locally.

## Usage

#### Deployment
Deploy code to an environment using Capistrano. Environment (env) can be staging or production.

	$ cap env deploy
