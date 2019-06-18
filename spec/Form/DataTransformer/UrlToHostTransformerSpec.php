<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\Form\DataTransformer;

class UrlToHostTransformerSpec extends AbstractTransformerSpec
{
    public function it_transforms(): void
    {
        $this->transform('example.com')->shouldReturn('example.com');
    }

    public function it_reverse_transforms(): void
    {
        $this->reverseTransform('http://example.com')->shouldReturn('example.com');
    }

    public function it_reverse_transforms_host(): void
    {
        $this->reverseTransform('example.com')->shouldReturn('example.com');
    }
}
