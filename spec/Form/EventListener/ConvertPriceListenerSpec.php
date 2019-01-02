<?php

namespace spec\Setono\SyliusStockPlugin\Form\EventListener;

use Money\Currency;
use Money\Money;
use Prophecy\Argument;
use Setono\SyliusStockPlugin\CurrencyConverter\CurrencyConverterInterface;
use Setono\SyliusStockPlugin\Form\EventListener\ConvertPriceListener;
use PhpSpec\ObjectBehavior;
use Setono\SyliusStockPlugin\Model\StockMovementInterface;
use Symfony\Component\Form\FormEvent;

class ConvertPriceListenerSpec extends ObjectBehavior
{
    public const BASE_CURRENCY = 'USD';

    public function let(CurrencyConverterInterface $currencyConverter): void
    {
        $currencyConverter->convertFromMoney(Argument::cetera())->willReturn(new Money(100, new Currency('USD')));

        $this->beConstructedWith($currencyConverter, self::BASE_CURRENCY);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ConvertPriceListener::class);
    }

    public function it_throws_exception(FormEvent $formEvent): void
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during('onPostSubmit', [$formEvent]);
    }

    public function it_does_not_convert(FormEvent $formEvent, StockMovementInterface $stockMovement): void
    {
        $formEvent->getData()->willReturn($stockMovement);
        $stockMovement->getPrice()->willReturn(null);
        $stockMovement->setConvertedPrice(Argument::any())->shouldNotBeCalled();

        $this->onPostSubmit($formEvent);
    }

    public function it_converts(FormEvent $formEvent, StockMovementInterface $stockMovement): void
    {
        $formEvent->getData()->willReturn($stockMovement);
        $stockMovement->getPrice()->willReturn(new Money(100, new Currency('USD')));
        $stockMovement->setConvertedPrice(Argument::any())->shouldBeCalled();

        $this->onPostSubmit($formEvent);
    }
}
