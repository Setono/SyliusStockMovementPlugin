<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\Form\DataTransformer;

class EmailsToArrayTransformerSpec extends AbstractTransformerSpec
{
    public function it_transforms(): void
    {
        $this->transform(['hello@example.com', 'john@example.com'])->shouldReturn('hello@example.com,john@example.com');
    }

    public function it_reverse_transforms(): void
    {
        $this->reverseTransform('hello@example.com,john@example.com')->shouldReturn(['hello@example.com', 'john@example.com']);
    }
}
