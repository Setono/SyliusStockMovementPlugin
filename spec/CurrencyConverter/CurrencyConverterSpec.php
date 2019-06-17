<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\CurrencyConverter;

use PhpSpec\ObjectBehavior;
use Setono\SyliusStockMovementPlugin\CurrencyConverter\CurrencyConverterInterface;

abstract class CurrencyConverterSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $cls = substr(static::class, 5, -4);
        $this->shouldHaveType($cls);
    }

    public function it_implements_currency_converter_interface(): void
    {
        $this->shouldImplement(CurrencyConverterInterface::class);
    }
}
