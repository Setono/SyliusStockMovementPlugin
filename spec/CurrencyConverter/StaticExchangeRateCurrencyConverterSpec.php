<?php

namespace spec\Setono\SyliusStockPlugin\CurrencyConverter;

use Money\Currency;
use Money\Money;
use Setono\SyliusStockPlugin\CurrencyConverter\StaticExchangeRateCurrencyConverter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Currency\Converter\CurrencyConverterInterface;

class StaticExchangeRateCurrencyConverterSpec extends ObjectBehavior
{
    public function let(CurrencyConverterInterface $currencyConverter): void
    {
        $currencyConverter->convert(Argument::cetera())->willReturn(1000);
        $this->beConstructedWith($currencyConverter);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(StaticExchangeRateCurrencyConverter::class);
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
