<?php

namespace spec\Setono\SyliusStockMovementPlugin\Form\DataTransformer;

use Money\Currency;
use Money\Money;

class MoneyToStringTransformerSpec extends AbstractTransformerSpec
{
    public function it_transforms(): void
    {
        $this->transform($this->getMoney())->shouldReturn('EUR 100');
    }

    public function it_reverse_transforms(): void
    {
        $money = $this->reverseTransform('EUR 100');
        $money->equals($this->getMoney())->shouldReturn(true);
    }

    private function getMoney(): Money
    {
        return new Money('100', new Currency('EUR'));
    }
}
