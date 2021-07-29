# LARAVEL DPAS

## Design Pattern As Service

## Installation

Via Composer

``` bash
$ composer require mindwingx/dpas --dev
```

### Usage

Assume that you know all about design patterns, You can implement design patterns skeleton as a service and serve it as
a custom service provider.

#### Supported patterns:

- Builder
- Factory
- Adapter
- Composite
- Decorator
- Proxy
- Chain of Responsibility
- Strategy

### Commands

- Create new service

``` bash
php artisan dpas:new <service-name>
```

- Add eloquent model to service classes

``` bash
php artisan dpas:new <service-name> -m=<model-name>
```

- Customize base path name of service(default path is 'Service')

``` bash
php artisan dpas:new <service-name> -p=<base-path-name>
```

### Security

If you discover any security related issues, please email milad.rg@gmail.com instead of using the issue tracker.

### Credits

- [Milad Roudgarian][link-author]

### License

MIT. Please see the [license file](license.md) for more information.

[link-packagist]: https://packagist.org/packages/mindwingx/dpas

[link-downloads]: https://packagist.org/packages/mindwingx/dpas

[link-author]: https://github.com/mindwingx

