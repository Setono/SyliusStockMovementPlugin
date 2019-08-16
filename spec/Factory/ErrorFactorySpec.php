<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\Factory;

use PhpSpec\ObjectBehavior;
use Setono\SyliusStockMovementPlugin\Factory\ErrorFactory;
use Setono\SyliusStockMovementPlugin\Factory\ErrorFactoryInterface;
use Setono\SyliusStockMovementPlugin\Model\ErrorInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ErrorFactorySpec extends ObjectBehavior
{
    public function let(FactoryInterface $factory, ErrorInterface $error): void
    {
        $factory->createNew()->willReturn($error);

        $this->beConstructedWith($factory);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ErrorFactory::class);
    }

    public function it_implements_interface(): void
    {
        $this->shouldImplement(ErrorFactoryInterface::class);
    }

    public function it_creates(ErrorInterface $error): void
    {
        $this->createNew()->shouldReturn($error);
    }

    public function it_creates_from_constraint_violation(ConstraintViolationInterface $constraintViolation, ErrorInterface $error): void
    {
        $constraintViolation->getPropertyPath()->willReturn('property');
        $constraintViolation->getMessage()->willReturn('message');

        $error->setMessage('property: message')->shouldBeCalled();

        $this->createFromConstraintViolation($constraintViolation)->shouldReturn($error);
    }
}
