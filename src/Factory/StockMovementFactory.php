<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Factory;

use Setono\SyliusStockMovementPlugin\Model\StockMovementInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class StockMovementFactory implements StockMovementFactoryInterface
{
    /** @var FactoryInterface */
    private $decoratedFactory;

    public function __construct(FactoryInterface $decoratedFactory)
    {
        $this->decoratedFactory = $decoratedFactory;
    }

    public function createNew(): StockMovementInterface
    {
        /** @var StockMovementInterface $obj */
        $obj = $this->decoratedFactory->createNew();

        return $obj;
    }

    public function createValid(int $quantity, ProductVariantInterface $variant, string $reference = null): StockMovementInterface
    {
        $obj = $this->createNew();

        $obj->setVariant($variant);
        $obj->setQuantity($quantity);
        $obj->setReference($reference);

        return $obj;
    }
}
