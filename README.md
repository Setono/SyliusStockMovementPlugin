# Sylius Stock Movement Plugin

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]

Log all stock movements in your shop. You can use this to create very accurate reports of your
inventory movements.

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
    
    - { resource: "@SetonoSyliusStockMovementPlugin/Resources/config/app/config.yaml" }
    
    # ...
```

### Step 4: Install assets

```bash
$ php bin/console assets:install
```

## API
Create a stock movement on the variant `variant-code` with a quantity of 1 and a price of €100:

```bash
curl -X POST \
  http://127.0.0.1:8000/api/v1/stock-movements/ \
  -H 'Accept: application/json' \
  -H 'Authorization: Bearer SampleToken' \
  -H 'Content-Type: application/json' \
  -d '{
	"quantity": 1,
	"variant": "variant-code",
	"price": "EUR 100"
}'
```

## Important
If you use the `StaticExchangeRateCurrencyConverter` (which is default) you **must** have an existing exchange rate between all your accepted currencies and your base currency.

[ico-version]: https://poser.pugx.org/setono/sylius-stock-movement-plugin/v/stable
[ico-unstable-version]: https://poser.pugx.org/setono/sylius-stock-movement-plugin/v/unstable
[ico-license]: https://poser.pugx.org/setono/sylius-stock-movement-plugin/license
[ico-travis]: https://travis-ci.org/Setono/SyliusStockMovementPlugin.svg?branch=master
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/SyliusStockMovementPlugin.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/setono/sylius-stock-movement-plugin
[link-travis]: https://travis-ci.org/Setono/SyliusStockMovementPlugin
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/SyliusStockMovementPlugin
