# Fuel LessCSS Compiler

This is a LESS compiler package for Fuel Framework, using lessphp by @leafo or nodejs.

LESS extends CSS with dynamic behavior such as variables, mixins, operations and functions.

More about *lesscss*: **http://lesscss.org/**

More about *lessphp*: **http://leafo.net/lessphp**

## New in 2.0

* Search modifications recursively in your less includes
* Compile your less with LessPHP implementation or the nodejs+node official one

## Installing

Clone from Github. Put it on `'packages_dir/less'` dir in and add to your app/config/config.php.

	git clone --recursive git://github.com/kriansa/fuel-less.git

Works with Fuel 1.1+

## Usage

```php
// will compile `less_source_dir`/style.less to base_url/assets/css/style.css and load it as CSS
Asset::less('style.less');

// same syntax as Asset::css()
Asset::less(array('style.less', 'file1.less', 'admin/style.less'));
```

## Config

Copy `PKGPATH/less/config/less.php` to your `APP/config/less.php` and change it as you need. You can also change these configs at runtime:

```php
// Using the basic Config for the default Asset instance
Config::set('asset.less_source_dir', APPPATH.'less/admin');
// Or using the new Asset Instance
Asset::forge('custom', array('less_source_dir' => APPPATH.'less/admin'));
```

## Updating submodules

In case you want to update the submodules (lessphp and lessjs)

	git pull --recurse-submodules

## License

Fuel LessCSS package is released under the MIT License.

Have fun!