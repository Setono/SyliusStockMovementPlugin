<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\Form\DataTransformer;

use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\DataTransformerInterface;

abstract class AbstractTransformerSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $cls = substr(static::class, 5, -4);
        $this->shouldHaveType($cls);
    }

    public function it_implements_data_transformer_interface(): void
    {
        $this->shouldImplement(DataTransformerInterface::class);
    }

    abstract public function it_transforms(): void;

    abstract public function it_reverse_transforms(): void;
}
