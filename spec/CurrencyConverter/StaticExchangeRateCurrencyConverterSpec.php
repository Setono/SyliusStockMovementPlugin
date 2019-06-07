<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\CurrencyConverter;

use Money\Currency;
use Money\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Setono\SyliusStockMovementPlugin\CurrencyConverter\StaticExchangeRateCurrencyConverter;
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
