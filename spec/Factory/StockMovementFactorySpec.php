<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\Factory;

use PhpSpec\ObjectBehavior;
use Setono\SyliusStockMovementPlugin\Factory\StockMovementFactory;
use Setono\SyliusStockMovementPlugin\Factory\StockMovementFactoryInterface;
use Setono\SyliusStockMovementPlugin\Model\StockMovementInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

class StockMovementFactorySpec extends ObjectBehavior
{
    public function let(FactoryInterface $factory, StockMovementInterface $stockMovement): void
    {
        $factory->createNew()->willReturn($stockMovement);

        $this->beConstructedWith($factory);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(StockMovementFactory::class);
    }

    public function it_implements_interface(): void
    {
        $this->shouldImplement(StockMovementFactoryInterface::class);
    }

    public function it_creates(StockMovementInterface $stockMovement): void
    {
        $this->createNew()->shouldReturn($stockMovement);
    }

    public function it_creates_valid(StockMovementInterface $stockMovement, ProductVariantInterface $variant): void
    {
        $stockMovement->setQuantity(10)->shouldBeCalled();
        $stockMovement->setVariant($variant)->shouldBeCalled();
        $stockMovement->setReference('reference')->shouldBeCalled();

        $this->createValid(10, $variant, 'reference')->shouldReturn($stockMovement);
    }
}
