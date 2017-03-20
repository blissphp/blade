# Use Blade outside of Laravel

Blade is a fantastic templating engine for PHP from Laravel ecosystem.
This class makes it easy to use Blade in your non-Laravel projects.

## Usage

Instantiate:

```php
$viewsDir = __DIR__ . '/views';
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

Blade documentation can be found here: https://laravel.com/docs/5.4/blade

## Credits

[Yury Plashenkov](https://github.com/plashenkov) (this library)  
[Taylor Otwell](https://github.com/taylorotwell) (Blade engine)

## License

This library is licensed under the [MIT license](LICENSE.md).
