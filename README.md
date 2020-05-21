# Use Blade outside of Laravel

Blade is a fantastic templating engine for PHP from Laravel ecosystem.
This class makes it easy to use Blade in your non-Laravel projects.

## Usage

Install it via composer:

```bash
composer require bliss/blade
```

Instantiate:

```php
require __DIR__ . '/vendor/autoload.php';

$viewsPath = __DIR__ . '/views';
$cachePath = __DIR__ . '/views_cache';

$blade = new \Bliss\Blade($viewsPath, $cachePath);
```

Note that you can pass an array of directories as a first parameter:

```php
$blade = new \Bliss\Blade([__DIR__ . '/views', __DIR__ . '/views-dir-2'], $cachePath);
```

Render a template:

```php
echo $blade->render('some-template', [
    'variable1' => $variable1,
    'variable2' => $variable2
]);
```

You can also pass variables like this (useful for setting global Blade variables):

```php
$blade['variable3'] = $variable3;
```

## Blade Documentation

Blade documentation can be found here: https://laravel.com/docs/blade

## Credits

[Yuri Plashenkov](https://plashenkov.com) (this library)  
[Taylor Otwell](https://github.com/taylorotwell) (Blade templating engine)

## License

This library is licensed under the [MIT license](LICENSE.md).
