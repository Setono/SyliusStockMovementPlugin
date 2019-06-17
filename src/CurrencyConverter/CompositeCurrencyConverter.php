<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\CurrencyConverter;

use Money\Money;
use Safe\Exceptions\StringsException;
use Setono\SyliusStockMovementPlugin\Exception\CurrencyConversionException;

final class CompositeCurrencyConverter extends CurrencyConverter
{
    /** @var CurrencyConverterInterface[] */
    private $currencyConverters;

    public function __construct(CurrencyConverterInterface ...$currencyConverters)
    {
        $this->currencyConverters = $currencyConverters;
    }

    /**
     * @throws StringsException
     */
    public function convert(int $amount, string $sourceCurrency, string $targetCurrency, array $conversionContext = []): Money
    {
        foreach ($this->currencyConverters as $currencyConverter) {
            if (!$currencyConverter->supports($amount, $sourceCurrency, $targetCurrency, $conversionContext)) {
                continue;
            }

            try {
                return $currencyConverter->convert($amount, $sourceCurrency, $targetCurrency, $conversionContext);
            } catch (CurrencyConversionException $e) {
                continue;
            }
        }

        throw new CurrencyConversionException($amount, $sourceCurrency, $targetCurrency, $conversionContext);
    }

    public function supports(int $amount, string $sourceCurrency, string $targetCurrency, array $conversionContext = []): bool
    {
        foreach ($this->currencyConverters as $currencyConverter) {
            if ($currencyConverter->supports($amount, $sourceCurrency, $targetCurrency, $conversionContext)) {
                return true;
            }
        }

        return false;
    }
}
