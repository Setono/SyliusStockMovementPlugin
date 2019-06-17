<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\CurrencyConverter;

use Money\Money;

abstract class CurrencyConverter implements CurrencyConverterInterface
{
    public function convertFromMoney(Money $money, string $targetCurrency, array $conversionContext = []): Money
    {
        return $this->convert((int) $money->getAmount(), $money->getCurrency()->getCode(), $targetCurrency, $conversionContext);
    }
}
