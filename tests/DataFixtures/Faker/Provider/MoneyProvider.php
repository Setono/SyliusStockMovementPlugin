<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusStockMovementPlugin\DataFixtures\Faker\Provider;

use Faker\Provider\Base as BaseProvider;
use Money\Currency;
use Money\Money;

final class MoneyProvider extends BaseProvider
{
    public function money(): Money
    {
        return new Money(self::numberBetween(1000, 10000), new Currency($this->generator->currencyCode));
    }
}
