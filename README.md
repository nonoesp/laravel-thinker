# A Set of Helpers for Laravel 5

A Laravel helper package for frequently used operations.

## Installation

Begin by installing this package through Composer. Edit your project’s `composer.json` file to require `nonoesp/thinker`.

```
"require": {
	"nonoesp/thinker": "5.2.*"
}
```

Next, update Composer from the Terminal:

```
composer update
```

Next, add the new providers to the `providers` array of `config/app.php`:

```
	'providers' => [
		// ...
		Nonoesp\Thinker\ThinkerServiceProvider::class,  
		// ...
	],
```

Then, add the class aliases to the `aliases` array of `config/app.php`:

```
	'aliases' => [
		// ...
		'Thinker' => Nonoesp\Thinker\Facades\Thinker::class,
		// ...
	],
```

## License

Thinker is licensed under the MIT license. (http://opensource.org/licenses/MIT)

## Me

I'm [Nono Martínez Alonso](http://nono.ma), an computational designer with a penchant for design, code, and simplicity. I tweet at [@nonoesp](http://www.twitter.com/nonoesp) and write at [Getting Simple](http://gettingsimple.com/). If you use this package, I would love to hear about it. Thanks!