Casset Addons
=============

Addons are extra classes which allow Casset to integrate with other third-party tools, in ways which are not possible using the callbacks.

Currently there is only one addon: Twig.
However, this will change if people require other addons.

Twig
----

This extension adds the following Casset functions to Twig:

 - `Casset::render`: `render_assets`
 - `Casset::render_js`: `render_js`
 - `Casset::render_css`: `render_css`
 - `Casset::img`: `img`
 - `Casset::get_filepath_img`: `img_url`
 - `Casset::css`: `add_css`
 - `Casset::js`: `add_js`

This list is somewhat arbitrary.
Please ask if you want others added to it.

To enable this extension, edit `config/parser.php`, and add `Casset_Addons_Twig` to the `extensions` key under 'View_Twig', like so:

```php
'View_Twig' => array(
	'extensions' => array(
		'Twig_Fuel_Extension',
		'Casset_Addons_Twig',
	),
),
```
