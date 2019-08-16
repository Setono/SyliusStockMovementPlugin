<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\Exception;

use PhpSpec\ObjectBehavior;
use Setono\SyliusStockMovementPlugin\Exception\ExceptionInterface;
use Setono\SyliusStockMovementPlugin\Exception\UnexpectedStatusException;

class UnexpectedStatusExceptionSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('actual', 'expected');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(UnexpectedStatusException::class);
    }

    public function it_implements_exception_interface(): void
    {
        $this->shouldImplement(ExceptionInterface::class);
    }

    public function it_returns_correct_properties(): void
    {
        $this->getActualStatus()->shouldReturn('actual');
        $this->getExpectedStatus()->shouldReturn('expected');

        $this->getMessage()->shouldReturn('Unexpected status. Status was "actual". Expected status was "expected"');
    }
}
