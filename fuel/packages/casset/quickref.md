Quick Reference
===============

This file gives a quick overview of all of Casset's methods and their options, with a little description for each.
This is useful if you're familiar with a bit of Casset's functionality, but can't remember the method name or usage.

Contents
--------

 - [Namespaces](#qr-namespaces): [add_path](#qr-add-path), [set_path](#qr-set-path).
 - [Groups](#qr-groups): [add_group](#qr-add-group), [group_exists](#qr-group-exists), [enable](#qr-enable), [disable](#qr-disable), [enable_js](#qr-enable-js), [disable_js](#qr-disable-js), [enable_css](#qr-enable-css), [disable_css](#qr-disable-css), [set_group_option](#qr-set-group-option), [set_js_option](#qr-set-js-option), [set_css_option](#qr-set-css-option), [add_deps](#qr-add-deps), [add_js_deps](#qr-add-js-deps), [add_css_deps](#qr-add-css-deps)
 - [Adding assets](#qr-adding-assets): [js](#qr-js), [css](#qr-css), [js_inline](#js-inline), [css_inline](#css-inline)
 - [Retrieving assets](#qr-retrieving-assets): [get_filepath](#qr-get-filepath), [get_filepath_js](#qr-get-filepath-js), [get_filepath_css](#qr-get-filepath-css), [get_filepath_img](#qr-get-filepath-img), [render](#qr-render), [render_js](#qr-render-js), [render_css](#qr-render-css), [render_js_inline](#qr-render-js-inline), [render_css_inline](#qr-render-css-inline)
 - [Callbacks](#qr-callbacks): [set_post_load_callback](#qr-set-post-load-callback), [set_filepath_callback](#qr-set-filepath-callback)
 - [Images](#qr-images): [img](#qr-img)
 - [Cache control](#qr-cache-control): [clear_cache](#qr-clear-cache), [clear_js_cache](#qr-clear-js-cache), [clear_css_cache](#qr-clear-css-cache)

<a name="qr-namespaces"></a>
Namespaces
----------

<a name="qr-add-path"></a>
### add_path
Adds a new namespace.

`add_path($path_key, $path_attr)`.

`$path_key`: The name of the namespace, e.g. "my_plugin".

`$path_attr`: *Either* a string showing the location of the namespace, *or* an array with the key 'path' (showing the location of the namespace), and zero or more of the keys 'js', 'css', 'img', giving the name of the js/css/img folder inside that namespace.

<a name="qr-set-path"></a>
### set_path
Sets the current default namespace.
The default namespace is the namespace which is used when no namespace is explicitely specified.

`set_path($path_key = 'core')`.

`$path_key`: The name of the namespace to make the default.

<a name="qr-groups"></a>
Groups
------

<a name="qr-add-group"></a>
### add_group
Adds a new group.

`add_group($group_type, $group_name, $files, $options = array()`.

`$group_type`: The type of group, 'js' or 'css'.

`$group_name`: The name of the group.

`$files`: An array of files to add to the group. Each can be either a string containing the filename, or an array of non-minified file and minified file, e.g .`array('file.js', 'file.min.js').

`$options`: An array of zero or more of the keys 'enabled', 'combine', 'min', 'inline', 'attr', 'deps'.
See the docs for a description of each.

<a name="qr-group-exists"></a>
### group_exists
Checks for the existence of a group.
Returns true if the group exists.

`bool group_exists($group_type, $group_name)`.

`$group_type`: The type of the group, 'js' or 'css'.

`$group_name`: The name of the group to check for.

<a name="qr-enable"></a>
### enable
Enables both the js and css groups (if they exist) with a particular name.

`enable($groups)`.

`$groups`: Either a string of the group name to enable, or an array of group names to enable.

<a name="qr-disable"></a>
### disable
disables both the js and css groups (if they exist) with a particular name.

`disable($groups)`.

`$groups`: Either a string of the group name to disable, or an array of group names to disable.

<a name="qr-enable-js"></a>
### enable_js
Enables the js group(s) with a particular name(s).

`enable_js($groups)`.

`$groups`: Either a string of the group name to enable, or an array of group names to enable.

<a name="qr-disable-js"></a>
### disable_js
disables the js group(s) with a particular name(s).

`disable_js($groups)`.

`$groups`: Either a string of the group name to disable, or an array of group names to disable.

<a name="qr-enable-css"></a>
### enable_css
Enables the css group(s) with a particular name(s).

`enable_css($groups)`.

`$groups`: Either a string of the group name to enable, or an array of group names to enable.

<a name="qr-disable-css"></a>
### disable_css
disables the css group(s) with a particular name(s).

`disable_css($groups)`.

`$groups`: Either a string of the group name to disable, or an array of group names to disable.

<a name="qr-set-group-option"></a>
### set_group_option
Sets the value of an option for one or more groups.

`set_group_option($type, $group_names, $option_key, $option_value)`.

`$type`: The type of group to change, 'js' or 'css'.

`$group_names`: Either a string of the group to change the option for, or an array of group names to change an option for.

`$option_key`: The name of the option, see `add_group` for valid options.

`$option_value`: The value of the option.

<a name="qr-set-js-option"></a>
### set_js_option
A shortcut for `set_group_option` for the type 'js'.

`set_js_option($group_names, $option_key, $option_value)`.

`$group_names`: Either a string of the group to change the option for, or an array of group names to change an option for.

`$option_key`: The name of the option, see `add_group` for valid options.

`$option_value`: The value of the option.

<a name="qr-set-css-option"></a>
### set_css_option
A shortcut for `set_group_option` for the type 'css'.

`set_css_option($group_names, $option_key, $option_value)`.

`$group_names`: Either a string of the group to change the option for, or an array of group names to change an option for.

`$option_key`: The name of the option, see `add_group` for valid options.

`$option_value`: The value of the option.

<a name="qr-add-deps"></a>
### add_deps
Add deps to a group.
This differs from passing 'deps' to `set_group_option`, as the deps are added to the deps which are specified already, rather than overriding them.

`add_deps($type, $group, $new_deps)`.

`$type`: The type of group to add deps to, 'js' or 'css'.

`$group`: The name of the group to add deps to.

`$new_deps`: Either a string of a new dep to add, or an array of such deps.

<a name="qr-add-js-deps"></a>
### add_js_deps
A shortcut for `add_deps` for the type 'js'.

`add_js_deps($group, $deps)`.

`$group`: The name of the group to add deps to.

`$deps`: Either a string of a new dep to add, or an array of such deps.

<a name="qr-add-css-deps"></a>
### add_css_deps
A shortcut for `add_deps` for the type 'css'.

`add_css_deps($group, $deps)`.

`$group`: The name of the group to add deps to.

`$deps`: Either a string of a new dep to add, or an array of such deps.

<a name="qr-adding-assets"></a>
Adding sssets
-------------

<a name="qr-js"></a>
### js
Adds a js asset, to the names group.

`js($script, $script_min = false, $group = 'global')`.

`$script`: The name of the file to add.

`$script_min`: The name of the minified file to add. If specified, this will be used when a minified file is desired, rather than auto-minifying `$script`.

`$group`: The name of the group to add the file to. If no such group exists, it will be created.

<a name="qr-css"></a>
### css
Adds a css asset, to the names group.

`css($sheet, $sheet_min = false, $group = 'global')`.

`$sheet`: The name of the file to add.

`$sheet_min`: The name of the minified file to add. If specified, this will be used when a minified file is desired, rather than auto-minifying `$sheet`.

`$group`: The name of the group to add the file to. If no such group exists, it will be created.

<a name="qr-js-inline"></a>
### js_inline
Add a string containing javascript, which can be printed with `js_render_inline`.

`js_inline($content)`.

`$content`: The string of javascript to add.

<a name="qr-acss-inline"></a>
### css_inline
Add a string containing cs, which can be printed with `css_render_inline`.

`css_inline($content)`.

`$content`: The string of css to add.

<a name="qr-retrieving-assets"></a>
Retriving assets
----------------

<a name="qr-get-filepath"></a>
### get_filepath
Gets the path to a named asset file, using namespacing, globs, etc.
Throws an exception if the file isn't found.
By default, when only one file is found, a string is returned, otherwise an array is returned.

`string/array get_filepath($filename, $type, $add_url = false, $force_array = false)`.

`$filename`: The name of the asset to find. Supports namespaces and globs.

`$type`: The type of asset to find, 'js', 'css', or 'img'.

`$add_url`: Whether to add the value from the 'url' config key to the filename.

`$force_array`: Whether to always return an array, regardless of whether one or many files are found.

<a name="qr-get-filepath-js"></a>
### get_filepath_js
A shortcut for `get_filepath`, with the type set to 'js'.

`string/array get_filepath_js($filename, $add_url = false, $force_array = false)`.

`$filename`: The name of the asset to find. Supports namespaces and globs.

`$type`: The type of asset to find, 'js', 'css', or 'img'.

`$add_url`: Whether to add the value from the 'url' config key to the filename.

`$force_array`: Whether to always return an array, regardless of whether one or many files are found.

<a name="qr-get-filepath-css"></a>
### get_filepath_css
A shortcut for `get_filepath`, with the type set to 'css'.

`string/array get_filepath_css($filename, $add_url = false, $force_array = false)`.

`$filename`: The name of the asset to find. Supports namespaces and globs.

`$type`: The type of asset to find, 'css', 'css', or 'img'.

`$add_url`: Whether to add the value from the 'url' config key to the filename.

`$force_array`: Whether to always return an array, regardless of whether one or many files are found.

<a name="qr-get-filepath-img"></a>
### get_filepath_img
A shortcut for `get_filepath`, with the type set to 'img'.

`string/array get_filepath_img($filename, $add_url = false, $force_array = false)`.

`$filename`: The name of the asset to find. Supports namespaces and globs.

`$type`: The type of asset to find, 'img', 'css', or 'img'.

`$add_url`: Whether to add the value from the 'url' config key to the filename.

`$force_array`: Whether to always return an array, regardless of whether one or many files are found.

<a name="qr-render"></a>
### render
Renders all enabled js/css groups, or just the named groups (provided that they are enabled).
Returns a set of `<script>`/`<link>` tag(s), as required.

`string render($group = false, $options = array())`.

`$group`: If false/null, render all groups. If a string, render just the named group.

`$options`: A set of options to control how/if the tags are rendered. See the docs for details.

<a name="qr-render-js"></a>
### render_js
Renders all enabled js groups, or just the named groups (provided that they are enabled).
Returns a set of `<script>` tag(s), as required.

`string render($group = false, $options = array())`.

`$group`: If false/null, render all groups. If a string, render just the named group.

`$options`: A set of options to control how/if the tags are rendered. See the docs for details.

<a name="qr-render-css"></a>
### render_css
Renders all enabled css groups, or just the named groups (provided that they are enabled).
Returns a set of `<link>` tag(s), as required.

`string render($group = false, $options = array())`.

`$group`: If false/null, render all groups. If a string, render just the named group.

`$options`: A set of options to control how/if the tags are rendered. See the docs for details.

<a name="qr-render-js-inline"></a>
### render_js_inline
Renders all js inline content, which was added with `js_inline`.

`string render_js_inline`.

<a name="qr-render-css-inline"></a>
### render_css_inline
Renders all css inline content, which was added with `css_inline`.

`string render_css_inline`.

<a name="qr-callbacks"></a>
Callbacks
---------

<a name="qr-set-post-load-callback"></a>
### set_post_load_callback.
Sets the post-load callback (see the docs).

`set_post_load_callback($callback)`.

`$callback`: The callback to use. Must have the prototype `function($content, $filename, $type, $group_name)`.

<a name="qr-set-filepath-callback"></a>
### set_filepath_callback.
Sets the filepath callback (see the docs).

`set_filepath_callback($callback)`.

`$callback`: The callback to use. Must have the prototype `function($filepath, $type, $remote)`.

<a name="qr-images"></a>
Images
------

<a name="qr-img"></a>
### img
Locates the given image(s), and returns the resulting `<img>` tag(s).

`string function img($images, $alt = '', $attr = array()`.

`$images`: Either a string of an image, or an array of such images. Namespaces are allowed.

`$alt`: The alt text of the image(s).

`$attr`: An array of attributes to add to the `<img>` tag, e.g. `array('width' => 500)`.

<a name="qr-cache-control"></a>
Cache control
-------------

<a name="qr-clear-cache"></a>
### clear_cache
Cleares all cache files last modified before the given time.

`clear_cache($before = 'now')`.

`$before`: The before which to delete cache files. any `strtotime`-compatible format allowed.

<a name="qr-clear-js-cache"></a>
### clear_js_cache
Cleares js files last modified before the given time.

`clear_js_cache($before = 'now')`.

`$before`: The before which to delete cache files. any `strtotime`-compatible format allowed.

<a name="qr-clear-css-cache"></a>
### clear_css_cache
Cleares css files last modified before the given time.

`clear_css_cache($before = 'now')`.

`$before`: The before which to delete cache files. any `strtotime`-compatible format allowed.
