<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Factory;

use Setono\SyliusStockMovementPlugin\Model\StockMovementInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface StockMovementFactoryInterface extends FactoryInterface
{
    /**
     * Will create a valid stock movement that can be persisted
     */
    public function createValid(int $quantity, ProductVariantInterface $variant, string $reference = null): StockMovementInterface;
}
