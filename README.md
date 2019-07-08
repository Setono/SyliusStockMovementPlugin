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
    
    League\FlysystemBundle\FlysystemBundle::class => ['all' => true],
    Setono\CronExpressionBundle\SetonoCronExpressionBundle::class => ['all' => true],
    Setono\SyliusStockMovementPlugin\SetonoSyliusStockMovementPlugin::class => ['all' => true],
    
    // It is important to add plugin before the grid bundle
    Sylius\Bundle\GridBundle\SyliusGridBundle::class => ['all' => true],
        
    // ...
];
```

**NOTE** that you must instantiate the plugin before the grid bundle, else you will see an exception like `You have requested a non-existent parameter "setono_sylius_stock_movement.model.report_configuration.class".`

### Step 3: Import routing

```yaml
# config/routes/setono_sylius_stock_movement.yaml
setono_sylius_stock_movement:
    resource: "@SetonoSyliusStockMovementPlugin/Resources/config/routing.yaml"
```

### Step 4: Configure plugin

```yaml
# config/packages/setono_sylius_stock_movement.yaml
imports:
    - { resource: "@SetonoSyliusStockMovementPlugin/Resources/config/app/config.yaml" }

setono_sylius_stock_movement:
    templates:
        - label: Default
          template: "@SetonoSyliusStockMovementPlugin/Template/default.txt.twig"
```

### Step 5: Update database schema

Use Doctrine migrations to create a migration file and update the database.

```bash
$ bin/console doctrine:migrations:diff
$ bin/console doctrine:migrations:migrate
```

### Step 6: Install assets

```bash
$ php bin/console assets:install
```

### Step 7 (optional): Create or import fixtures

- Import fixtures:

    ```yaml
    # config/packages/_sylius.yaml
    imports:
        # ...
        - { resource: "@SetonoSyliusStockMovementPlugin/Resources/config/app/fixtures.yaml" }
    ```

- Or create your own:
    
    ```yaml
    # config/fixtures.yaml
    sylius_fixtures:
        suites:
            YOUR_SUITE:
                fixtures:
                    setono_stock_movement:
                        options:
                            amount: 1000
    ```

## API
Create a stock movement on the variant `variant-code` with a quantity of 1:

```bash
brew install jq
SYLIUS_HOST=http://127.0.0.1:8000
SYLIUS_ADMIN_API_ACCESS_TOKEN=$(curl $SYLIUS_HOST/api/oauth/v2/token \
    --silent --show-error \
    -d "client_id"=demo_client \
    -d "client_secret"=secret_demo_client \
    -d "grant_type"=password \
    -d "username"=api@example.com \
    -d "password"=sylius-api | jq '.access_token' --raw-output)
SYLIUS_SOME_PRODUCT_CODE=$(curl $SYLIUS_HOST/api/v1/products/?limit=1 \
    --silent --show-error \
    -H "Authorization: Bearer $SYLIUS_ADMIN_API_ACCESS_TOKEN" \
    -H "Accept: application/json" | jq '._embedded.items[0].code' --raw-output)
echo "Some product code: $SYLIUS_SOME_PRODUCT_CODE"
SYLIUS_SOME_PRODUCT_VARIANT_CODE=$(curl $SYLIUS_HOST/api/v1/products/$SYLIUS_SOME_PRODUCT_CODE/variants/?limit=1 \
    --silent --show-error \
    -H "Authorization: Bearer $SYLIUS_ADMIN_API_ACCESS_TOKEN" \
    -H "Accept: application/json"| jq '._embedded.items[0].code' --raw-output)
echo "Some product variant code: $SYLIUS_SOME_PRODUCT_VARIANT_CODE"

curl $SYLIUS_HOST/api/v1/stock-movements/ \
  -X POST \
  -H 'Accept: application/json' \
  -H "Authorization: Bearer $SYLIUS_ADMIN_API_ACCESS_TOKEN" \
  -H 'Content-Type: application/json' \
  -d "{
	\"quantity\": 1,
	\"variant\": \"$SYLIUS_SOME_PRODUCT_VARIANT_CODE\"
}"
```

[ico-version]: https://poser.pugx.org/setono/sylius-stock-movement-plugin/v/stable
[ico-unstable-version]: https://poser.pugx.org/setono/sylius-stock-movement-plugin/v/unstable
[ico-license]: https://poser.pugx.org/setono/sylius-stock-movement-plugin/license
[ico-travis]: https://travis-ci.org/Setono/SyliusStockMovementPlugin.svg?branch=master
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/SyliusStockMovementPlugin.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/setono/sylius-stock-movement-plugin
[link-travis]: https://travis-ci.org/Setono/SyliusStockMovementPlugin
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/SyliusStockMovementPlugin
