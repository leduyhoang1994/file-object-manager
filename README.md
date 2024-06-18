# This is my package file-object-manager

[![Latest Version on Packagist](https://img.shields.io/packagist/v/red-flag/file-object-manager.svg?style=flat-square)](https://packagist.org/packages/red-flag/file-object-manager)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/red-flag/file-object-manager/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/red-flag/file-object-manager/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/red-flag/file-object-manager/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/red-flag/file-object-manager/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/red-flag/file-object-manager.svg?style=flat-square)](https://packagist.org/packages/red-flag/file-object-manager)

Laravel package for managing file with ORM

## Features
- Advanced Upload with [Uppy](https://uppy.io/)
- Support Storage drivers: s3, local
- Improve upload speed with pre-signed url

## Prerequisites

- PHP version: ^8.1
- Laravel version: ^10
- Database: Any

## Installation

You can install the package via composer:

```bash
composer require red-flag/file-object-manager
```

1. Publish the config file with:

```bash
php artisan vendor:publish --tag="file-object-manager-config"
```
<i>View the config file for more information</i>

2. Skip this step if you already have table for FileObject 
- Publish and run the migrations with:

```bash
php artisan vendor:publish --tag="file-object-manager-migrations"
php artisan migrate
```

3. Publishing the assets

```bash
php artisan vendor:publish --tag="file-object-manager-assets"
```

## Usage

1. Add js library into head tag

```html
<head>
    ...
    <script src="/vendor/file-object-manager/js/file-object-manager.js"></script>
</head>
```

2. Init File Object Manager UI

```html
<body>
    ...
    <div id="file-object-manager">

    </div>
    <script type="module">
        const options = {}; // View document for more information
        FileObjectManager.init('#file-object-manager', options);
    </script>
</body>
```

## Documentation

- [Document Link](https://wiki.onschool.edu.vn/display/UNI3/File+Object+Manager)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Red Flag](https://github.com/leduyhoang1994)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
