<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\CurrencyConverter;

use Money\Currency;
use Money\Money;
use Sylius\Component\Currency\Converter\CurrencyConverterInterface;

final class StaticExchangeRateCurrencyConverter extends CurrencyConverter
{
    private $currencyConverter;

    public function __construct(CurrencyConverterInterface $currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
    }

    public function convert(int $money, string $sourceCurrency, string $targetCurrency): Money
    {
        // notice that Sylius' currency converter will return the same amount if the source > target currency pair does not exist
        // i.e. if you give an input like EUR 100 and your target is USD, but no exchange rate exists between EUR and USD
        // Sylius' currency converter will return 100
        $converted = $this->currencyConverter->convert($money, $sourceCurrency, $targetCurrency);

        return new Money($converted, new Currency($targetCurrency));
    }
}
