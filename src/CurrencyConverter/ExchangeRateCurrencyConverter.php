<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\CurrencyConverter;

use Money\Currency;
use Money\Money;
use Sylius\Component\Currency\Converter\CurrencyConverterInterface;

final class ExchangeRateCurrencyConverter extends CurrencyConverter
{
    private $currencyConverter;

    public function __construct(CurrencyConverterInterface $currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
    }

    public function convert(int $money, string $sourceCurrency, string $targetCurrency): Money
    {
        $converted = $this->currencyConverter->convert($money, $sourceCurrency, $targetCurrency);

        return new Money($converted, new Currency($targetCurrency));
    }
}
