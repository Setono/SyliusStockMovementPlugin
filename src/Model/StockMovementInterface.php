<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

use Money\Money;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface StockMovementInterface extends ResourceInterface
{
    /**
     * The number of items.
     *
     * If the quantity is negative it means an outgoing stock movement, i.e. you've sold a product
     * Contrary a positive number means an ingoing stock movement, i.e. you had a return or a delivery
     *
     * @return int
     */
    public function getQuantity(): ?int;

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void;

    /**
     * @return ProductVariantInterface|null
     */
    public function getVariant(): ?ProductVariantInterface;

    /**
     * @param ProductVariantInterface|null $productVariant
     */
    public function setVariant(?ProductVariantInterface $productVariant): void;

    /**
     * @return string
     */
    public function getVariantCode(): ?string;

    /**
     * This is the original sales price
     *
     * @return Money
     */
    public function getPrice(): ?Money;

    /**
     * @param Money $price
     */
    public function setPrice(Money $price): void;

    /**
     * This is the converted price after the applied currency converter
     *
     * @return Money
     */
    public function getConvertedPrice(): ?Money;

    /**
     * @param Money $convertedPrice
     */
    public function setConvertedPrice(Money $convertedPrice): void;

    /**
     * @return string|null
     */
    public function getReference(): ?string;

    /**
     * @param string|null $reference
     */
    public function setReference(?string $reference): void;
}
