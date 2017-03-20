# Use Blade outside of Laravel

Blade is a fantastic template engine fro PHP built into Laravel.
This class allows to use it outside of Laravel.

## Usage

Instantiate:

```php
$viewsPath = __DIR__ . '/views';
$cachePath = __DIR__ . '/views_cache';

$blade = new \Bliss\Blade($viewsPath, $cachePath);
```

Note that you can tell Blade to use multiple template paths.
Just pass an array as first parameter for that.

Render template:

```php
echo $blade->render('some-template', [
    'variable1' => $variable1,
    'variable2' => $variable2
]);
```

You can also pass variables in such way (useful for global variables, etc.):

```php
$blade['variable3'] = $variable3;
```

## Credits

[Yury Plashenkov](https://github.com/plashenkov)  
Thanks [Taylor Otwell](https://github.com/taylorotwell) for Blade template engine itself.

## License

This library is licensed under the [MIT license](LICENSE.md).
