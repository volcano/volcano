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

Set up file permissions and run migrations:

	$ php oil r setup
