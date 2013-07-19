# eReceivables 2.0

## Introduction

This should help you get started with the eReceivables 2.0 project.

## Installation
Clone the repo:

	$ git clone ssh://git@code.onesite.com/er/ereceivables.git

Initialize all submodules:

	$ cd ereceivables && git submodule update --init --recursive

Update Composer dependencies:

	$ php composer.phar self-update
	$ php composer.phar update

## Configuration
Create a new local database.

Update the dev database config (`fuel/app/config/development/db.php`).

Set file permissions and run migrations:

	$ php oil r setup

Insert a new record into the api_keys table.

Copy the key you inserted and add it to `fuel/app/config/development/api.php` so that you don't have to specify the api_key param when testing locally.
