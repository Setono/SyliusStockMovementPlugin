<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

use Money\Money;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface StockMovementInterface extends ResourceInterface
{
    /**
     * @return int
     */
    public function getQuantity(): int;

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void;

    /**
     * @return ProductVariantInterface|null
     */
    public function getProductVariant(): ?ProductVariantInterface;

    /**
     * @param ProductVariantInterface|null $productVariant
     */
    public function setProductVariant(?ProductVariantInterface $productVariant): void;

    /**
     * @return string
     */
    public function getProductVariantCode(): string;

    /**
     * @return Money
     */
    public function getPrice(): Money;

    /**
     * @param Money $price
     */
    public function setPrice(Money $price): void;

    /**
     * @return Money
     */
    public function getConvertedPrice(): Money;

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
