# Sylius Stock Plugin

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]

Adds stock related capabilities to your Sylius shop.

## Installation


### Step 1: Download the plugin

Open a command console, enter your project directory and execute the following command to download the latest stable version of this plugin:

```bash
$ composer require setono/sylius-stock-movement-plugin
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.


### Step 2: Enable the plugin

Then, enable the plugin by adding it to the list of registered plugins/bundles
in the `config/bundles.php` file of your project:

```php
<?php

return [
    // ...
    
    JK\MoneyBundle\JKMoneyBundle::class => ['all' => true],
    Setono\CronExpressionBundle\SetonoCronExpressionBundle::class => ['all' => true],
    Setono\SyliusStockMovementPlugin\SetonoSyliusStockMovementPlugin::class => ['all' => true],
    
    // It is important to add plugin before the grid bundle
    Sylius\Bundle\GridBundle\SyliusGridBundle::class => ['all' => true],
        
    // ...
];
```

**NOTE** that you must instantiate the plugin before the grid bundle, else you will see an exception like `You have requested a non-existent parameter "setono_sylius_stock_movement.model.report_configuration.class".`

### Step 3: Import config
Import the config file somewhere in your application. Could be the `config/packages/_sylius.yaml` file.

```yaml
imports:
    # ...
    
    - { resource: "@SetonoSyliusStockMovementPlugin/Resources/config/config.yaml" }
    
    # ...
```

## Important
If you use the `StaticExchangeRateCurrencyConverter` (which is default) you **must** have an existing exchange rate between all your accepted currencies and your base currency.

[ico-version]: https://img.shields.io/packagist/v/setono/sylius-stock-plugin.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/Setono/SyliusStockPlugin/master.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/SyliusStockPlugin.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/setono/sylius-stock-plugin
[link-travis]: https://travis-ci.org/Setono/SyliusStockPlugin
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/SyliusStockPlugin
