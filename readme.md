# laravel-composer

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Travis](https://img.shields.io/travis/emtiazzahid/laravel-composer.svg?style=flat-square)]()
[![Total Downloads](https://img.shields.io/packagist/dt/emtiazzahid/laravel-composer.svg?style=flat-square)](https://packagist.org/packages/emtiazzahid/laravel-composer)

![image](https://user-images.githubusercontent.com/10188029/73999285-72e4c380-498e-11ea-87cb-a834b2275e7d.png)


## Install
`composer require emtiazzahid/laravel-composer`

Add Service Provider to `config/app.php` in `providers` section
```php
Emtiazzahid\LaravelComposer\LaravelComposerServiceProvider::class,
```

Add a route in your web routes file:
```php 
Route::get('composer', '\EmtiazZahid\LaravelComposer\LaravelComposerController@index');
```

Go to `http://myapp/composer` or some other route

**Optionally** publish `index.blade.php` into `/resources/views/vendor/laravel-composer/` for view customization:

```
php artisan vendor:publish \
  --provider="EmtiazZahid\LaravelComposer\LaravelComposerServiceProvider" \
  --tag=views
``` 

## Usage
Write a few lines about the usage of this package.

## Testing
Run the tests with:

``` bash
vendor/bin/phpunit
```

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Md. Emtiaz Zahid](https://github.com/emtiazzahid)
- [All Contributors](https://github.com/emtiazzahid/laravel-composer/contributors)

## Security
If you discover any security-related issues, please email emtiazzahid@gmail.com instead of using the issue tracker.

## License
The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.
