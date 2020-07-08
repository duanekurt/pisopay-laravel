# Repository Title Goes Here

Laravel Package for pisopay checkout

---

## Installation

- All the `code` required to get started
- Images of what it should look like

### Setup

- To install the package

> composer require savants/pisopay-laravel

- After that add this to your `config/app.php`
```php
'providers' => [
    Savants\PisopayWrapper\PisopayWrapperServiceProvider::class,
  ];
```
- Publish the config files

> php artisan vendor:publish --provider="Savants\PisopayWrapper\PisopayWrapperServiceProvider"

- Add this to your env

```env
PISOPAY_USERNAME=
PISOPAY_PASSWORD=
XGATEWAYAUTH=
```

## License

[![License](http://img.shields.io/:license-mit-blue.svg?style=flat-square)](http://badges.mit-license.org)

- **[MIT license](http://opensource.org/licenses/mit-license.php)**
- Copyright 2015 © <a href="http://fvcproductions.com" target="_blank">FVCproductions</a>.
