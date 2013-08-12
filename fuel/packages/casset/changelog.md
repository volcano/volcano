Changelog
=========

This file lists the important changes between versions. For a list of minor changes, check the log.

v1.21
-----
 - Move CSS @import statements to top of combined files

v1.20
-----
 - Update addons/readme.md to document more twig functions
 - Add customisable root path

v1.19
-----
 - Prevent globs from matching folders
 - $asset_url is, by default, scheme-relative. You'll have to update your config/casset.php to benefit though (see the new default)
 - More twig extension functions (add_css, add_js)

v1.18
-----
 - Add a new CSS URI rewriting algorithm ('relative'), which should fix the problems with using the (original) absolute rewriting with a symlinked docroot.

v1.17
-----
 - `js_inline` and `css_inline` won't spit out lots of consecutive tags.
 - Casset_Exception inherits from FuelException instead of the (deprecated) Fuel_Exception.
 - Various documentation fixes.

v1.16
-----
 - Add 'img_url' to twig extension, and improve twig docs slightly.
 - Default for $alt argument fof img() is now an empty string.

v1.15
----
 - Add `render`, `render_js`, `render_css` and `img` to a new Twig extension. See `classes/casset/addons/readme.md`.
 - Fix various typos.

v1.14
-----
 - Add gen_tags option to render_js and render_css.
 - Fix bug with combine() and groups containing pre-minified files.

v1.13
-----
 - Add quickref.md -- ideal for quickly accessing the API, assuming you know roughly what you're looking for.
 - Fix bug where the js_dir, etc, config settings made no difference to the core namespace.
 - Script paths prefixed with a leading slash will ignore the path specified by js_dir, etc.

v1.12
-----
 - `<link>` and `<script>` tags now respect whether document is HTML5
 - New hook: filepath_callback. Allows you to modify the URL, as used by Casset, of js/css files, and images. See the readme.
 - New function: group_exists.
 - set_group_option changes default group options (for add future groups) when used with '*' as the group name.
 - Lots of private methods are now protected.
 - CSS URIs are rewritten when the stylesheet is inlined and not minified.
 - Update to minification libraries.
 - Any non-string assets names are ignored.
 - Fix bug with generating stylesheet tags.
 - Various documentation additions and fixes.

v1.11
-----
 - Asset URLs can be obtained, see "Getting asset paths / urls".
 - Casset::add_group() has been re-implemented.
 - Callbacks now exist: You can use these to process js/css files after they're loaded, but before they're cached. Allows use of SASS, Coffeescript, etc.
 - Exception now thrown if someone attempts to define a group that already exists.
 - Group options are now specified using array syntax, instead of separate function arguments.
 - Option to inline groups moved from Caset::render() to when the group's defined.
 - Option to add attributes to a group's tag moved from Casset::render() to when the group's defined.
 - Add dependencies between groups. Rendering a group will automatically render its dependencies.
 - New functions to allow changing of group options on-the-fly.

v1.10
-----
Hotfix release.
Fixed #3, reported by krtek4, where render_css had an erroneous second loop, meaning that it would render files when it wasn't supposed to

v1.9
---
Hotfix release.
Fixes #1, reported by jaysonic, where add_path was (for some reason) private.

v1.8
----

- CSS files are no longer sorted, instead keeping the order they were added to the group in.
- Allow overriding of js_dir, css_dir and img_dir on a per-path basis (see the 'paths' config key).
- `Casset::render()` lost its 'min' parameter. Instead, minification can be controlled on a per-group basis from the config file.
- 'combine' option added. Read the readme ("Minification and combining") for details on how to use this with the 'min' option. This addition changes the behaviour of 'min' slighlty, but shouldn't break anything.
- Assets at remote locations are now supported. There are (necessarily) some gotchas, so please read the readme!
- The 'enabled' option in the 'groups' config key is now optional, and defaults to true.
