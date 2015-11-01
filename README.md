# Thinker for Laravel 5

A Laravel 5 helper package for frequently-used operations—so you don't have to think.

## Usage

	composer require nonoesp/thinker:dev

	php artisan vendor:publish --provider="Nonoesp\Thinker\ThinkerServiceProvider" --tag=middleware

Inside `app/Http/Kernel.php` add the following:

```php
protected $routeMiddleware = [
    […]
    'login' => \Arma\Http\Middleware\LoginMiddleware::class,
];
```

*Deprecated of version for Laravel 4*

## Installation

Run `compose require nonoesp/thinker:dev-master`

Add `'Nonoesp/Thinker/ThinkerServiceProvider',` to `providers` in `/app/config/app.php`

## Changelog

0.4

* Fixed Laravel classes.

0.3

* First release.
* Added methods from old Helper.
* Added description.

## License

Thinker is licensed under the MIT license. (http://opensource.org/licenses/MIT)

## Me

I tweet at [@nonoesp](http://www.twitter.com/nonoesp) and blog at [nono.ma/says](http://nono.ma/says). If you use this package, I would love to hear about it. Thanks!