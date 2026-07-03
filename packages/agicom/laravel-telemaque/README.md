
<p align="center"><img src="/art/logo.png" height="100" alt="Laravel Telemaque"></p>

<div align="center">


# Laravel Telemaque

A Laravel/PHP package that helps you easily retrieve data from Telemaque.

[![Coding Standards Action Status](https://github.com/agicom/laravel-telemaque/workflows/coding-standards/badge.svg)](https://github.com/agicom/laravel-telemaque/actions/workflows/coding-standards.yml)
[![Static Analysis Action Status](https://github.com/agicom/laravel-telemaque/workflows/static-analysis/badge.svg)](https://github.com/agicom/laravel-telemaque/actions/workflows/static-analysis.yml)
[![Tests Action Status](https://github.com/agicom/laravel-telemaque/workflows/tests/badge.svg)](https://github.com/agicom/laravel-telemaque/actions/workflows/tests.yml)

</div>

## Introduction
Package intro.

> ⚠️ Version 1.4.0 requires Laravel 11 and Livewire 3

## Installation

You can install the package via composer:

```bash
composer require agicom/laravel-telemaque
```

Publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-telemaque-config"
```

Add the following environment variables into your .env file:

```sh
TELEMAQUE_BASE_URL=https://telemaque-domain.com
TELEMAQUE_API_VERSION=v1
TELEMAQUE_TOKEN=your-token-here
```

## Usage

```php
use Agicom\Telemaque\Facades\Telemaque;

// Retreive an agency by code
$agency = Telemaque::agency('012345');
echo $agency->city; //Paris

// Retreive an agency by sbuuid
$agency = Telemaque::agency('97a1d3fe-09fa-11ee-be56-0242ac120002');
echo $agency->city; //Paris
```

```php
use Agicom\Telemaque\Facades\Telemaque;

$user = Telemaque::user('pdupont@domain.com');
echo $user->nom; // Dupont
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [bnzo](https://github.com/bnzo)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
