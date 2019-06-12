<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\CurrencyConverter;

use Money\Money;

interface CurrencyConverterInterface
{
    /**
     * Will convert the given money in the source currency to a money object in the target currency
     */
    public function convert(int $money, string $sourceCurrency, string $targetCurrency): Money;

    /**
     * Will convert the given money object to a new money object in the target currency
     */
    public function convertFromMoney(Money $money, string $targetCurrency): Money;
}
