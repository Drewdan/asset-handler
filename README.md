# Prometheus Markdown Asset Uploader

This is a companion package for the Prometheus Markdown Editor https://www.npmjs.com/package/prometheus-markdown

Built for Laravel, it registers a route which is the default route for the Markdown Editor to 
upload assets too. Once uploaded, a URL is returned for use within the markdown editor.

## Installation

Best installed via composer:

```
composer require drewdan/asset-handler
```

Publish the config files using this command:

```
php artisan vendor:publish --provider="Drewdan\AssetHandler\AssetHandlerServiceProvider" --tag="config"
```

The configuration looks like this:

```PHP
<?php

return [
	'disk' => 'public',
	'storage_path' => 'assets',
	'use_original_filename' => false,
	'route' => [
		'prefix' => 'markdown-assets',
		'middleware' => null,
	],
];

```

Use this to configure the disk you wish to store the assets on. Please note, some disks
require additional dependencies and keys. Consult the Laravel docs for more details on
this: https://laravel.com/docs/8.x/filesystem

You can also configure the storage path, whether you wish to keep the original filename and
some route configurations, including the route prefix, which by default is markdown-assets.
You can change this if necessary to prevent route collisions with your existing application
and apply any middleware that is necessary.

By default, this route has no middleware to prevent CSRF errors. However, you can add any
middleware you require using this config option.

