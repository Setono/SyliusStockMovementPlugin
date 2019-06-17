<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\CurrencyConverter;

use Money\Currency;
use Money\Money;
use Sylius\Component\Currency\Converter\CurrencyConverterInterface;

class StaticExchangeRateCurrencyConverterSpec extends AbstractCurrencyConverterSpec
{
    public function let(CurrencyConverterInterface $currencyConverter): void
    {
        $currencyConverter->convert(100, 'EUR', 'USD')->willReturn(1000);
        $this->beConstructedWith($currencyConverter);
    }

    public function it_supports_everything(): void
    {
        $this->supports(10, 'EUR', 'USD')->shouldReturn(true);
    }

    public function it_converts(): void
    {
        $money = $this->convert(100, 'EUR', 'USD');

        $money->shouldBeAnInstanceOf(Money::class);
        $money->getCurrency()->shouldBeAnInstanceOf(Currency::class);
        $money->getAmount()->shouldBeEqualTo('1000');
        $money->getCurrency()->getCode()->shouldBeEqualTo('USD');
    }
}
