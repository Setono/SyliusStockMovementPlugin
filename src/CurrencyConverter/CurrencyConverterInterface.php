<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\CurrencyConverter;

use Money\Money;
use Setono\SyliusStockMovementPlugin\Exception\CurrencyConversionException;

interface CurrencyConverterInterface
{
    /**
     * Will convert the given money in the source currency to a money object in the target currency
     *
     * @throws CurrencyConversionException if the conversion fails
     */
    public function convert(int $amount, string $sourceCurrency, string $targetCurrency, array $conversionContext = []): Money;

    /**
     * Will convert the given money object to a new money object in the target currency
     *
     * @throws CurrencyConversionException if the conversion fails
     */
    public function convertFromMoney(Money $money, string $targetCurrency, array $conversionContext = []): Money;

    /**
     * Returns true if this currency converter supports the given parameters
     */
    public function supports(int $amount, string $sourceCurrency, string $targetCurrency, array $conversionContext = []): bool;
}
