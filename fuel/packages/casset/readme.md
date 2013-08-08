Casset
======

Casset is an alternative to fuelphp's Asset class.  
Casset supports minifying and combining scripts, in order to reduce the number and size of http requests need to load a given page. Grouping syntax has been made cleaner, and the ability to render all groups, and enable/disable specific groups, added.  
There are are some other changes too, please read on!

Thanks to Stephen Clay (and Douglas Crockford) for writing the minification libraries, stolen from http://code.google.com/p/minify/.

If you have any comments/queries, either send me a message on github, post to the fuelphp [forum thread](http://fuelphp.com/forums/topics/view/2187), catch me on #fuelphp, or open an issue.

If you're just after a quick reference, or a reminder of the API, see the the file `quickref.md`.

Installation
------------

### Using oil
1. cd to your fuel project's root
2. Run `php oil package install casset`
3. Optionally edit fuel/packages/casset/config/casset.php (the defaults are sensible)
4. Create public/assets/cache
5. Add 'casset' to the 'always_load/packages' array in app/config/config.php (or call `Fuel::add_package('casset')` whenever you want to use it).
6. Enjoy :)

### Manual (may be more up-to-date)
1. Clone (`git clone git://github.com/canton7/fuelphp-casset`) / [download](https://github.com/canton7/fuelphp-casset/zipball/master)
2. Stick in fuel/packages/
3. Optionally edit fuel/packages/casset/config/casset.php (the defaults are sensible)
4. Create public/assets/cache
5. Add 'casset' to the 'always_load/packages' array in app/config/config.php (or call `Fuel::add_package('casset')` whenever you want to use it).
6. Enjoy :)

If you don't want to change the config file in `fuel/packages/casset/config/casset.php`, you can create your own config file in `fuel/app/config/casset.php`.
You can either copy the entirely of the original config file, or just override the keys as you like.
The magic of Fuel's `Config` class takes care of the rest.

Introduction
------------

Casset is an easy-to-use asset management library. It boasts the following features:

- Speficy which assets to use for a particular page in your view/controller, and print them in your template.
- Collect your assets into groups, either pre-defined or on-the-fly.
- Enable/disable specific groups from your view/controller.
- Minify your groups and combine into single files to reduce browser requests and loading times.
- Define JS/CSS in your view/controller to be included in your template.
- Namespace your assets.

Basic usage
-----------

JS and CSS files are handled the same way, so we'll just consider JS. Just substitude 'js' with 'css' for css-related functions.

Javascript files can be added using the following, where "myfile.js" and "myfile2.js" are the javascript files you want to include,
and are located at public/assets/js/myfile.js and public/assets/js/myfile2.js (configurable).

```php
Casset::js('myfile.js');
Casset::js('myfile2.js');
```

By default, Casset will minify both of these files and combine them into a single file (which is written to public/assets/cache/\<md5 hash\>.js).
To include this file in your page, use the following:

```php
echo Casset::render_js();
/*
Returns something like
<script type="text/javascript" src="http://localhost/site/assets/cache/d148a723c710760bc62ca3ecc8c50206.js?1307384477"></script>
*/
```

If you've got minification turned off (see the section at the bottom of this readme), you'll instead get:

```php
<script type="text/javascript" src="http://localhost/site/assets/js/myfile.js"></script>
<script type="text/javascript" src="http://localhost/site/assets/js/myfile2.js"></script>
```

If you have a specific file ("myfile.min.js") which you want Casset to use, rather than generating its own minified version, you
can pass this as the second argument, eg:

```php
Casset::js('myfile.js', 'myfile.min.js');
```

Some folks like css and js tags to be together. `Casset::render()` is a shortcut which calls `Casset::render_css()` then `Casset::render_js()`.

Images
------

Although the original Asset library provided groups, etc, for dealing with images, I couldn't see the point.

Therefore image handling is somewhat simpler, and can be summed up by the following line, where the third argument is an optional array of attributes:

```php
echo Casset::img('test.jpg', 'alt text', array('width' => 200));
```

You can also pass an array of images (which will all have to same attributes applied to them), eg:

```php
echo Casset::img(array('test.jpg', 'test2.jpg'), 'Some thumbnails');
```

This function has more power when you consider namespacing, detailed later.

Groups
------

Groups are collections of js/css files.
A group can be defined in the config file, or on-the-fly. They can be enabled and disabled invidually, and rendered individually.

CSS and JS have their own group namespaces, so feel free to overlap.

To define a group in the config file, use the 'groups' key, eg:

```php
'groups' => array(
	'js' => array(
		'group_name' => array(
			'files' => array(
				array('file1.js', 'file1.min.js'),
				'file2.js'
			),
			'combine' => false,
			'min' => false,
			'inline' => true
		),
		'group_name_2' => array(.....),
	),
	'css' => array(
		'group_name' => array(
			'files' => array(
				array('file1.css', 'file1.min.css'),
				'file2.css',
			),
			'enabled' => false,
			'attr' => array('media' => 'print'),
			'deps' => array('some_group'),
		),
		'group_name_3' => array(.....),
	),
),
```

As you can see, the javascript and css groups are entirely separate.
Each group consists of the following parts:  
**files**: a list of files present in the group. Each file definition can either be a string or a 2-element array.
If you're using minification, but have a pre-minified copy of your file (jquery is an example), you can pass this as the second
array element.  
**enabled**: Optional, specifies whether a group is enabled. A group will only be rendered when it is enabled. Default true.  
**combine**: This optional key allows you to override the 'combine' config key on a per-group bases.  
**min**: This optional key allows you to override the 'min' config key on a per-group basis.  
**inline**: Optional, allows you to render the group 'inline' -- that is, show the CSS directly in the file, rather than including a separate .css file. See the section on inling below.  
**attr**: Optional, allows you to specify extra attributes to be added to the script/css/link tag generated. See the section on attributes below.  
**deps**: (Optional) Specifies other groups to be rendered whenever this group is rendered, see the section below.

Aside: You can specify any non-string value for the asset name, and it will be ignored.
This can be handy if you're doing something like `'files' => array(($var == $val) ? false : 'file.js')`.

Groups can be enabled using `Casset::enable_js('group_name')`, and disabled using `Casset::disable_js('group_name')`. CSS equivalents also exist.  
The shortcuts `Casset::enable('group_name')` and `Casset::disable('group_name')` also exist, which will enable/disable both the js and css groups of the given name, if they are defined.  
You can also pass an array of groups to enable/disable.

Specific groups can be rendered using eg `Casset::render_js('group_name')`. If no group name is passed, *all* groups will be rendered.  
Note that when a group is rendered, it is disabled. See the "Extra attributes" section for an application of this behaviour.

Files can be added to a group by passing the group name as the third argument to `Casset::js` / `Casset::css`, eg:

```php
Casset::js('myfile.js', 'myfile.min.js', 'group_name');
Casset::css('myfile.css', false, 'group_name');
```

(As an aside, you can pass any non-string value instead of 'false' in the second example, and Casset will behave the same: generate your minified file for you.)

If the group name doesn't exist, the group is created, and enabled.

You can also add groups on-the-fly using `Casset::add_group($group_type, $group_name, $files, $options)`, where `$options`is an array with *any* of the following keys:

```php
$options = array(
	'enabled' => true/false,
	'min' => true/false,
	'combine' => true/false,
	'inline' => true/false,
	'attr' => array(),
	'deps' => array(),
);
```

The arguments are the same as for the config key -- if `'enabled'`, `'combine'` or `'min'` are omitted, the value specified in the config file are used. Eg:

```php
Casset::add_group('test_group', array(
	array('file1.js', 'file1.min.js'),
	'file2.js',
));
```

This method is provided merely for convenience when adding lots of files to a group at once.
You don't have to create a group before adding files to it -- the group will be created it it doesn't exist.

You can change any of these options on-the-fly using `Casset::set_group_option($type, $group, $key, $value)`, or the CSS- and JS- specific versions, `Casset::set_js_option($group, $key, $value)` and `Casset::set_css_option($group, $key, $value)`.
`$group` has some special values: an empty string is a shortcut to the 'global' group (to which files are added if a group is not specified), and '*' is a shortcut to all groups.
Multiple group names can also be specified, using an array.

Examples:

```php
// Add a dep to the my_plugin group
Casset::set_js_option('my_plugin', 'deps', 'jquery');

// Make all files added to the current page using Casset::add_css() display inline:
Casset::set_css_option('', 'inline', true);

// Turn off minification for all groups, regardless of per-group settings, for the current page:
Casset::set_js_option('*', 'min', false);
```

When you call `Casset::render()` (or the js- and css-specific varients), the order that groups are rendered is determined by the order in which they were created, with groups present in the config file appearing first.
Similarly (for JS files only), the order in which files appear is determined by the order in which they were added.
This allows you a degree of control over what order your files are included in your page, which may be necessary when satisfying dependencies.
If this isn't working for you, or you want something a bit more explicit, try this: If file A depends on B, add B to its own group and explicitely render it first.

NOTE: Calling ``Casset::js('file.js')`` will add that file to the "global" group. Use / abuse as you need!

NOTE: The arguments for `Casset::add_group` used to be different. Backwards compatibilty is maintained (for now), but you are encouranged to more to the new syntax.

Paths and namespacing
---------------------

The Asset library searches through all of the items in the 'paths' config key until it finds the first matching file.
However, this approach was undesirable, as it means that if you had the directory structure below, and tried to include 'index.js', the file that was included would be determined by the order of the
entries in the paths array.

```
assets/
   css/
   js/
      index.js
   img/
   admin/
      css/
      js/
	     index.js
      img/
```

Casset brings decent namespacing to the rescue!
For the above example, you can specify the following in your config file:

```
'paths' => array(
	'core' => 'assets/',
	'admin' => 'assets/admin/',
),
```

You can also add paths on-the-fly using `Casset::add_path($key, $path)`, eg.

```php
Casset::add_path('admin', 'assets/admin/');
```

Which path to use is then decided by prefixing the asset filename with the key of the path to use. Note that if you omit the path key, the current default path key (initially 'core') is used.

```php
Casset::js('index.js');
// Or
Casset::js('core::index.js');
// Will add assets/js/index.js

Casset::js('admin::index.js');
// Will add assets/admin/js/index.js

echo Casset::img('test.png', 'An image');
// <img src="...assets/img/test.png" alt="An image" />

echo Casset::img('admin::test.png', 'An image');
// <img src="...assets/admin/img/test.png" alt="An image" />
```

If you wish, you can change the current default path key using `Casset::set_path('path_key')`. This can be useful if you know that all of the assets in a given file will be from a given path. For example:

```php
Casset::set_path('admin);
Casset::js('index.js');
// Will add assets/admin/js/index.js
```

The "core" path can be restored by calling `Casset::set_path()` with no arguments (or calling `Casset::set_path('core')`).

You can also namespace the files listed in the config file's 'groups' section, in the same manner.
Note that these are loaded before the namespace is changed from 'core', so any files not in the core namespace will have to by explicitely prepended with the namespace name.

In addition, you can override the config options 'js_path', 'css_path' and 'img_path' on a per-path basis. In this case, the element of the 'paths' config array takes the following form,
where each of 'js_path', 'css_path' and 'img_path' are optional. If they are not specified, the defaults will be used.

```php
array (
	'some_key' => array(
		'path' => 'more_assets/',
		'js_dir' => 'javascript/',
		'css_dir' => 'styles/',
		'img_dir' => 'images/',
	),
),
```

This can be particularly useful when you're using some third-party code, and don't have control over where the assets are located.

Note also that you can add an asset which uses a path which isn't yet defined.
Casset only requires that the path is defined by the time the file is rendered.

If you add an asset whose path starts with a leading slash, the folder specified by 'js_dir', 'css_dir', etc (either in the config or in the namespace), is ignored.
This can be handy if you have a third-party module which, for example, puts css inside the js/ folder.
For example:

```php
Casset::js('some_key::file.js')
// Adds more_assets/javascript/file.js
Casset::js('some_key::/file.js')
// Adds more_assets/file.js
```

Globbing
--------

As well as filenames, you can specify [glob patterns](http://php.net/glob). This will act exactly the same as if each file which the glob matches had been added individually.  
For example:

```php
Casset::css('*.css');
// Runs glob('assets/css/*.css') and adds all matches.

Casset::css('admin::admin_*.css');
// (Assuming the paths configuration in the "Paths and namespacing" section)
// Executes glob('adders/admin/css/admin_*.css') and adds all matches

Casset::js('*.js', '*.js');
// Adds all js files in assets/js, ensuring that none of them are pre-minified.
```

An exception is thrown when no files can be matched.

Dependencies
------------

Casset allows you to specify dependancies between groups, which are automatically resolved.
This means that you can, say, define a group for your jQuery plugin, and have jQuery automatically included every time that plugin is included.

Note that dependancies can only be entire groups -- groups can not depend on individual files.
This has to do with how files are put into cache files, email me if you're interested.

A JS group can only depend on other JS groups, while a CSS group can only depend on other CSS groups.

Casset is pretty intelligent, and will only include a file once, before the file that requires it.
After a file has been required as a dependency, it will be disabled.
Casset will also bail after following the dependency chain through a certain number of steps, to avoid cycling dependancies.
This value is given by the config key 'deps_max_depth'.

The easiest way of specifying dependancies is through the config file:

```php
'groups' => array(
	'js' => array(
		'jquery' => array(
			'files' => array(
				array('jquery.js', 'jquery.min.js'),
			),
		),
		
		'my_plugin' => array(
			'files' => array(
				'jquery.my_plugin.js',
			),
			'deps' => array(
				'jquery',
			),
		),
	),
),
```

Dependencies can be either a string (for a single dependency), or an array (for multiple ones).

You can also define dependencies when you call `Casset::add_group()`, by using the `'deps'` key in `$options`.

 Eg:
 
 ```php
Casset::add_group('js', 'my_plugin', array('jquery.my_plugin.js'), array(
	'deps' => 'jquery',
));
 ```

In addition, the functions `Casset::add_js_deps()` and `Casset::add_css_deps()` exist, which can be used like:

```php
Casset::add_js_deps('group_name', array('this', 'groups', 'deps'));
```

As usual, there's another base function, `Casset::add_deps()`, which takes 'js' or 'css' as its first argument, but is otherwise identical.

If you have a JS group A, which depends on both the JS group B and CSS group B, a useful trick is to create a CSS group A with no files, that depends on the CSS group B.
Therefore whenever group A is rendered, both the JS group B and CSS group B will be rendered.

Inlining
--------

If you want Casset to display a group inline, instead of linking to a cache file, you can mark the group as 'inline' when you create it.

```php
// In your config (see add_group also)
'groups' => array(
	'js' => array(
		'my_inline_group' => array(
			'files' => array('file.css'),
			'inline' => true,
		),
	),
),
```

NOTE: You could previously pass an argument to `Casset::render()` to tell it to render the group inline.
This behaviour has been deprecated, although it still works.
You are encouraged to move away from this technique if you are using it.

Occasionally it can be useful to declare a bit of javascript in your view, but have it included in your template. Casset allows for this, although it doesn't support groups and minification
(as I don't see a need for those features in this context -- give me a shout if you find an application for them, and I'll enhance).

In your view:

```php
$bar = 'baz';
$js = <<<EOF
	var foo = "$bar";
EOF;
Casset::js_inline($js);
```

In your template:

```php
echo Casset::render_js_inline();
/*
Will output:
<script type="text/javascript">
	var foo = "baz";
</script>
*/
```

Similarly, `Casset::css_inline()` and `Casset::render_css_inline()` exist.

Extra attributes
----------------

If you want to apply extra attributes to the script/link tag, you can add them to the group config, using the key 'attr'.
For example:

```php
// In your config
'groups' => array(
	'css' => array(
		'my_print' => array(
			'files' => array('file.css'),
			'attr' => array('media' => 'print'),
		),
	),
),

// Render the 'my_print' group, along with the others
echo Casset::render_css();
// <link rel="stylesheet" type="text/css" href="http://...somefile.css" media="print" />
```

You can also pass them in the `$options` argument to `Casset::add_group()`, for example:

```php
Casset::add_group('js', 'my_deferred_js', array(
	'file.js',
	), array(
	'attr' => array(
		'defer' => 'defer',
	),
);

echo Casset::render_js();
// <script type="text/javascript" src="http://...somefile.js" defer="defer"></script>
```

NOTE: You used to be able to pass an `$attr` argument to `Casset::render()`.
This behaviour has been deprecated, although it still works.
Please move to the new system.

Minification and combining
--------------------------

Minification uses libraries from Stephen Clay's [Minify library](http://code.google.com/p/minify/).

The 'min' and 'combine' config file keys work together to control exactly how Casset operates:

**Combine and minify:**
When an enabled group is rendered, the files in that group are minified (or the minified version used, if given, see the second parameter of eg `Casset::js()`),
and combined into a single cache file in public/assets/cache (configurable).

**Combine and not minify:**
When an enabled group is rendered, the files in that group are combined into a a single cache file in public/assets/cache (configurable). The files are not minified.

**Not combine and minify:**
When an enabled group is rendered, a separate `<script>` or `<link>` tag is created for each file.
If a minified version of a file has been given, it will be linked to. Otherwise, the non-minified version is linked to.
NOTE THAT THIS MIGHT BE UNEXPECTED BEHAVIOUR. It is useful, however, when linking to remote assets. See the section on remote assets.

**Not combine and not minify**
When an enabled group is rendered, a separate `<script>` or `<link>` tag is created for each file.
The non-minified version of the file is used in each case.

You can choose to include a comment above each `<script>` and `<link>` tag saying which group is contained with that file by setting the "show_files" key to true in the config file.
Similarly, you can choose to put comments inside each minified file, saying which origin file has ended up where -- set "show_files_inline" to true.

You can control whether Casset minifies or combines individual groups, see the groups section.

When minifying CSS files, urls are rewritten to take account of the fact that your css file has effectively moved into `public/assets/cache`.

With both CSS and JS files, when a cache file is used, changing the order in which files were added to the group will re-generate the cache file, with the files in their new positions.
This is because the order of files can be important, as dependancies may need to be satisfied.
Bear this in mind when adding files to groups dynamically -- if you're changing the order of files in an otherwise identical group, you're not allowing
the browser to properly use its cache.

NOTE: If you change the contents of a group, and a cache file is used, a new cache file will be generated. However the old one will not be removed (groups are mutable,
so Casset doesn't know whether a page still uses the old cache file).
Therefore an occasional clearout of `public/assets/cache/` is recommended. See the section below on clearing the cache.

Remote files
------------

Casset supports handing files on remote machines, as well as the local one.
This is done by creating a new namespace, and specifying a url instead of a relative path.
All files using that namespace will then be fetched from the given url.

However, there are a couple of caveats:  
 - It is possible for Casset to fetch, combine and minify remote assets. However, it can obviously only write the cache file locally.  
 - Casset doesn't bother to check the modification times on remote files when deciding whether the cache is out of date (as this would cause lots of http requests from your server, and entirely defeat
   the point of caching in the first place). Therefore if the remote file changes, Casset's cache will not be updated, and you'll have to remove it manually, or with the cache-clearing functions.

For this reason, recommended practice is to either turn off combining files entirely if using remote assets (possibly undesirable),
or create one or more groups dedicated to remote files, in which combination is disabled.

Note that when combining files is disabled, but minification enabled, each file in the group will have its own `<script>` or `<link>` tag, but the minified version of the file will be linked to, if supplied.
If no minified version of the file is supplied, the non-minified version will be linked to.  
This behaviour was designed for use when using remote assets, where the desired behaviour is to avoid caching the file locally, instead leaving it on the remote server.

Here is an example, using the Google API libraries:

```php
// In config/casset.php
'paths' => array(
	'core' => 'assets/',
	'google_api' => array(
		'path' => 'http://ajax.googleapis.com/ajax/libs/',
		'js_dir' => '',
	),
),

'groups' => array(
	'js' => array(
		'jquery' => array(
			'files' => array(
				array('google_api::jquery/1.6.2/jquery.js', 'google_api::jquery/1.6.2/jquery.min.js'),
			),
			'enabled' => true,
			'combine' => false,
		),
	),
),

// Then you can also do....
Casset::js('google_api::jqueryui/1.8.14/jquery-ui.js', 'google_api::jqueryui/1.8.14/jquery-ui.min.js', 'jquery');


echo Casset::render();

// If minification is disabled:
// <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.js"></script>
// <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.14/jquery-ui.js"></script>

// If minification is enabled:
// <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
// <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.14/jquery-ui.min.js"></script>
```

Getting asset paths / urls
--------------------------

Thanks to [Peter](http://fuelphp.com/forums/posts/view_reply/3097) for this one. You can ask Casset for the path / url to a specific file.
Files are specified in exactly the same way as with eg `Casset::js()`, with the same rules to do with namespacing, `Casset::set_path()`, etc.

The functions in question are `Casset::get_filepath_js()`, `Casset::get_filepath_css()`, and `Casset::get_filepath_img()`.

They're all used in the same way:

```php
echo Casset::get_filepath_js('file.js');
// assets/js/file.js
```

Note that fuel executes in the `/public` directory, so the paths returned are relative to the current working dir.
If you'd prefer urls to be returned, pass `true` as the second parameter.
Note that a url will not be added if you're referencing a remote file.

```php
echo Casset::get_filepath_js('file.js', true);
// eg http://localhost/site/public/assets/js/file.js
```

Complexities start arising when you specify globs.
By default, an array will be returned if more than one file is found, otherwise a string is returned.
To override this behaviour, and return an array even if only one file is found, pass `true` as the third parameter.

```php
print_r(Casset::get_filepath_js('file.js', false, true));
// Array( [0] => 'assets/js/file.js' )

print_r(Casset::get_filepath_js('file*.js'));
// Array( [0] => 'assets/js/file1.js', [1] => 'assets/js/file2.js' )
```

There also exists `Casset::get_filepath()`, which takes the form

```php
Casset::get_filepath($name, $type, $add_url = false, $force_array = false);
```

`$name`, `$add_url` and `$force_array` are the same as for `Casset::get_filepath_js()`, while the `$type` argument is one of 'js', 'css', or 'img'.
In the future there are plans to let you specify your own types, hence why this is exposed :)

Controlling whether tags are generated
--------------------------------------

Thanks to antitoxic for motivating this feature.

The `get_filepath_*` functions are useful if you want to link directly to an asset.
However, this doesn't cover the case where you want to, for whatever reason, generate your own `<script>` or `<link>` tags, while still keeping Casset's minification/combining functionality.

The solution to this is to passed `array('gen_tags' => false)` as the second argument of `render_css()`/`render_js()`.
This will make `render_*` return an array of filenames / file contents (depending on whether you've turned on inlining for that group), rather then a string of tags (and maybe content).

For example:

```php
Casset::js('test_file.js');
Casset::render_js(false);
// Returns <script type="text/javascript" src="http://....test_file.js"></script>
Casset::render_js(false, array('gen_tags' => false));
// Returns Array (
//   [0] => "http://....test_file.js"
// )

Casset::set_group_option('js', 'global', 'inline', true);
Casset::render_js(false);
// Returns <script type="text/javascript">Some javascript file content</script>
Casset::render_js(false, array('gen_tags' => false));
// Returns Array (
//   [0] => "Some javascript file content"
// )
```

If more than one `<script>`/`<link>` tag would normally be generated, the array return will contain more than one element.

Clearing the cache
------------------
Since cache files are not automatically removed (Casset has no way of knowing whether a cache file might be needed again), a few methods have been provided to remove cache files.

`Casset::clear_cache()` will clear all cache files, while `Casset::clear_js_cache()` and `Casset::clear_css_cache()` will remove just JS and CSS files respectively.  
All of the above functions optionally accept an argument allowing you to only delete cache files last modified before a certain time. This time is specified as a
[strtotime](http://php.net/strtotime)-formatted string, for example "2 hours ago", "last Tuesday", or "20110609".  
For example:

```php
Casset::clear_js_cache('2 hours ago');
// Removes all js cache files last modified more than 2 hours ago

Casset::clear_cache('yesterday');
// Removes all cache files last modified yesterday
```

Callbacks
---------

### post_load_callback

Quick thanks to [ShonM](https://github.com/shonm) for pushing so hard to get this feature implemented :)

The post_load callback allows you the flexibility to do you own processing on the files that Casset loads.
This means that you can use SASS, CoffeeScript, etc, then configure Casset to call the appropriate compiler when it loads the asset.

Note that the `post_load` is *only* called when the 'combine' config key is set to true.
If 'combine' is false, Casset doesn't generate a cache file and instead links to the asset directly.
No cache file = no processing of the file by Casset = no callback.
If you really need this changed, send me a message and I'll start hacking :)

Processing files (beyond minification) is not really what Casset is about, and this reflects in the callback design.
There is a single callback, which is called for all files, regardless of group, type, extension, etc.
The callback is passed the name of the file, the type (js or css) and the group to which it belongs,as well as the file content of course.
It is then up to you to decide how, if at all, you want to process this content, based on the other parameters passed.

You can either define your callback using `Casset::set_post_load_callback()`, or you can pass the name of a function to call to the config key `post_load_callback`.
`Casset::set_post_load_callback()` expects an anonymous function (closure), although I daresay you could bind it straight to some other library's method.
Unfortunately, fuel doesn't allow you to define closues in your config (it tries to evaluate them to get a value to assign to the config key).

The callback itself has the following prototype, although you can miss out the latter arguments if you want: PHP won't complain.

```php
function($content, $filename, $type, $group_name) { ... }
```

Where:  
`$content`: The content of the file which Casset has read, and is passing to you.  
`$filename`: The name of the file which Casset has read.  
`$type`: 'js' or 'css', depending on whether the file is js or css.  
`$group_name`: The group which is currently being rendered, and to which the file belongs.

Obviously, the callback is only called when a cache file is generated.
When testing, therefore, it is recommended that you stick a `Casset::clear_cache()` above your testing code.

Time for a few examples:

```php
// In a controller somewhere
Casset::set_post_load_callback(function($content, $filename) {
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	if ($ext != 'sass')
		return $content;
	return SomeSassLibrary::some_method($content);
});

// In the config file:
'post_load_callback' => 'my_callback_name',
```

Note that Casset is pretty lazy, so the callback won't be called under you call `Casset::render()` (or one of its variants).
Therefore feel free to define your callback after telling Casset to include the files you want the callback to process.

### filepath_callback

Thanks to [leekudos](https://github.com/leekudos) for pushing for this one, and for numerous suggestions and comments.

This callback was implenented to solve one particular problem. However, it has been generalised in case you manage to find another use.

The original problem was this: There are some very large images on the server, so have been cached for a very long time.
This means that the url of the image has to be changed every time the image changes.
Now what if we could get Casset to do this url changing for us....

The filepath callback is called, basically, whenever Casset has generated a URL, but has not yet committed to using it.
This allows you to modify that URL.

More specifically:

 - `img()` calls it just before writing the <img> tag.
 - `render_css()` and `render_js()` call it just before writing a \<script src=".."\> or \<link href="..."\> tag to the page.

The callback itself has the following prototype:

```php
function($filepath, $type, $remote) { ... }
```

Where:  
`$filepath`: The path to the asset. Doesn't include the part of the URL specified by the 'url' config key, although will be a full URL if the asset is located on another server.  
`$type`: The type of asset: 'js', 'css' or 'img' currently.  
`$remote`: True if the asset is located on another server, false otherwise.

As with the post_local callback, this callback can either be specified directly using `Casset::set_filepath_callback()`, or the name of a function to call can be specified in the config, under the 'filepath_callback' key.

A trivial example:

```php
// Adds the string '?query=hello' to the end of all local js urls
Casset::set_filepath_callback(function($filepath, $type, $remote) {
	if ($remote || $type != 'js')
		return $filepath;
	return $filepath.'?query=hello';
});
```

Back to addressing the original problem (large cached images).
Appending the last modified time of the file to the end of the URL is one option, but this doesn't necessarily work in all browsers.
However, inserting the mtime into the middle of the filename will certainly work.
This needs some .htaccess magic, but that's OK.

Somewhere in your project:

```php
// Rewrite e.g. assets/img/file.jpeg to assets/img/file.1298892196.jpg
Casset::set_filepath_callback($filepath, $type, $remote) {
	if ($remote || $type != 'img')
		return $filepath;

	$pathinfo = pathinfo($filepath);
	$mtime = filemtime(DOCROOT.$filepath);
	return $pathinfo['dirname'].$pathinfo['basename'].'.'.$mtime.'.'.$pathinfo['extension'];
});
```

In your .htaccess:

```
# Rewrite e.g. http://example.com/assets/img/test.1298892196.jpg to http://example.com/assets/img/test.jpg
# Needs to be ABOVE the lines for removing index.php, if they exist.
RewriteRule ^(.*)\/(.+)\.([0-9]+)\.(js|css|jpg|jpeg|gif|png)$ $1/$2.$4 [L]
```

CSS URI Rewriting Algorithms
----------------------------

You probably only need to read this section if you've noticed URLs in your css files being broken by Casset.

A bit of background: when a css file is rewritten, the rewritten css is stored in a cache file.
This cache file is (probably) stored in a different location to the original file, so all relative urls will be broken.
Therefore Casset rewrites all of your urls for you.

Casset supplies a number of algorithms, which are listed below.
None of them are entirely foolproof.

### Absolute Rewriter

The default algorithm, this rewrites all urls to be absolute, so they start with a /.
It was written by Stephen Clay as part of his Minify package, is well tested, and works for 99% of cases.

Where it fails is when your document root is a symlink, in which case the algorithm is unable to determine the correct document root, and ends up garbling the urls.
There is a workaround (providing an array of symlinks) but this is not yet supported by Casset.

### Relative Rewriter

This algorithm takes the current location of the cache file, and the original location of the css file, and constructs a relative url between the two paths.
It's newer than the absolute rewriter, and hasn't been as extensively tested.
It therefore might have some corner cases it break in -- if you find one, please create an issue!
However, it should be able to handle the symlink problem which the absolute rewriter fails at.

### No rewriting

The other option is to turn off rewriting completely.
Some people may decide they simply don't need it.
In addition, the post_load callback allows you to do your own rewriting -- or should: I've never tried it, so you might not be given enough information; raise an issue if this is the case.
If you decide to do this, you'll probably want to turn off Casset's rewriting.

The algorithm is specified using the `css_uri_rewriter` config key.
This can take values of 'absolute', 'relative', or 'none'.

CSS @import rewriting
---------------------

CSS `@import` statements need to come at the beginning of the file in which they appear.
Combining files obviously screws this up, as lines which were at the beginning of a file could now be somewhere in the middle of the combined file.
If the config key `move_imports_to_top` is true (the default) then casser will take all `@import` lines and move them to the top of the combined file.
If this is causing problems, you can disable this feature.

Addons
------

Casset also ships with the following addons, to ease integration with third-party frameworks.
For more details, see `classes/casset/addons/readme.md`.

 - **Twig** - Adds the `render`, `render_js`, `render_css`, and `img` functions to Twig.

Comparison to Assetic
---------------------

A frequent question is how Casset differs from kriswallsmith's [Assetic](https://github.com/fuel-packages/fuel-assetic). InCasset and Assetic have completely different goals.

* Assetic is a very powerful asset mangement framework. It allows you to perform minification, compression and compilation on your assets, although learning it will take time.
* Casset is designed to make assets very easy to handle. You call `Casset::js()` then `Casset::render_js()`, and everything is taken care of.

If you're a developer tasked with fully optimising your site's page load time, for example, go with Assetic. If you want a very easy way to manage your assets, with some minification
thrown in for free, (and have no need for Assetic's complex features), go with Casset.

Examples
--------

Let's say we have a site which uses jquery on every page, jquery-ui on some pages, and then various other odds and sods.

In the config file:

```php
'groups' => array(
	'js' => array(
		'jquery' => array(
			'files' => array(
				array('jquery.js', 'jquery.min.js'),
			),
			'enabled' => true,
		),
		'jquery-ui' => array(
			'files' => array(
				array('jquery-ui.js', 'jquery-ui.min.js'),
			),
			'enabled' => false,
		),
	),
	'css' => array(
		'jquery-ui' => array(
			'files' => array(
				'jquery-ui.css',
			),
			'enabled' => false,
		),
	),
),
```

In our template file:

```html
...
<head>
<?php echo Casset::render_css() ?>
</head>
...
<body>
...
<?php
	echo Casset::render_js();
	echo Casset::render_js_inline();
?>
</body>
```

We can then turn the jquery-ui group on as we please.

file_1.php: (doesn't use jquery-ui)

```php
...
Casset::js('file_1.js');
Casset::css('file_1.css');
...
```

file_2.php: (does use jquery-ui)

```php
...
Casset::js('file_2.js');
Casset::css('file_2.css');
Casset::enable('jquery-ui');
...
```

Thanks
------

The following people have helped Casset become what it is, so thank you!

 - [ShonM](https://github.com/shonm)
 - [Lee Overy](https://github.com/leekudos)
 - [Chris Meller](https://github.com/chrismeller)
 - [monsonis](https://github.com/monsonis)
 - [Anton Stoychev](https://github.com/antitoxic)
 - [gnodeb](https://github.com/gnodeb)
 - [Derek Myers](https://github.com/dmyers)
 - [Ian Turgeon](https://github.com/iturgeon)
 - [Peter Wiggers](https://github.com/pwwebdev)
 - Katsuma Ito
 - [Adam McCann](https://github.com/exnor)

Contributing
------------

If you've got any issues/complaints/suggestions, please tell me and I'll do my best!

Pull requests are also gladly accepted. This project uses [git flow](http://nvie.com/posts/a-successful-git-branching-model/), so please base your work on the tip of the `develop` branch, and rebase onto `develop` again before submitting the pull request.
For example:

```bash
# Fork canton7/fuelphp-casset on github
# Clone your new repo
$ git clone git@github.com:your_user/fuelphp-casset.git
# Add my repo as a remote, so you can pull in new changes, then fetch from it
$ git remote add upstream git://github.com/canton7/fuelphp-casset.git
$ git fetch upstream
# Create a new feature branch based off my develop branch
$ git checkout -b feature/my_feature_name upstream/develop
# Push this branch to origin
$ git push -u origin feature/my_feature_name
# Work work work... Git add, commit, etc, as normal
# Update your copy of my develop branch
$ git fetch upstream
# Rebase your feature branch back on top of my develop branch
$ git rebase upstream/develop
# Force-push just this up to origin (as the rebase will have rewritten it)
$ git push -f origin feature/my_feature_branch
# Submit the pull request to github!
```
