<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Factory;

use Money\Money;
use Setono\SyliusStockPlugin\Model\StockMovementInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface StockMovementFactoryInterface extends FactoryInterface
{
    /**
     * Will create a valid stock movement that can be persisted
     *
     * @param int $quantity
     * @param ProductVariantInterface $productVariant
     * @param Money $price
     * @param string|null $reference
     *
     * @return StockMovementInterface
     */
    public function createValid(
        int $quantity,
        ProductVariantInterface $productVariant,
        Money $price,
        ?string $reference = null
    ): StockMovementInterface;
}
