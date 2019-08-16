<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\Exception;

use PhpSpec\ObjectBehavior;
use Setono\SyliusStockMovementPlugin\Exception\BlockNotPresentException;
use Setono\SyliusStockMovementPlugin\Exception\ExceptionInterface;

class BlockNotPresentExceptionSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('block', ['defined_block1', 'defined_block2'], 'template');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(BlockNotPresentException::class);
    }

    public function it_implements_exception_interface(): void
    {
        $this->shouldImplement(ExceptionInterface::class);
    }

    public function it_returns_correct_properties(): void
    {
        $this->getBlock()->shouldReturn('block');
        $this->getDefinedBlocks()->shouldReturn(['defined_block1', 'defined_block2']);
        $this->getTemplate()->shouldReturn('template');

        $this->getMessage()->shouldReturn('The block "block" is not present in the defined blocks ["defined_block1", "defined_block2"] of your template template');
    }
}
