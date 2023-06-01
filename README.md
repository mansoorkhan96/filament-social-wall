# This is my package filament-social-wall

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mansoor/filament-social-wall.svg?style=flat-square)](https://packagist.org/packages/mansoor/filament-social-wall)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/mansoor/filament-social-wall/run-tests?label=tests)](https://github.com/mansoor/filament-social-wall/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/mansoor/filament-social-wall/Check%20&%20fix%20styling?label=code%20style)](https://github.com/mansoor/filament-social-wall/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mansoor/filament-social-wall.svg?style=flat-square)](https://packagist.org/packages/mansoor/filament-social-wall)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require mansoor/filament-social-wall
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-social-wall-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-social-wall-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-social-wall-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filament-social-wall = new Mansoor\FilamentSocialWall();
echo $filament-social-wall->echoPhrase('Hello, Mansoor!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mansoor](https://github.com/mansoorkhan96)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
