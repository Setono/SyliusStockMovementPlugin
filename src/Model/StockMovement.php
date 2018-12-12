<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

use Money\Money;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

class StockMovement implements StockMovementInterface
{
    use TimestampableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * The number of items.
     *
     * If the quantity is negative it means an outgoing stock movement, i.e. you've sold a product
     * Contrary a positive number means an ingoing stock movement, i.e. you had a return or a delivery
     *
     * @var int
     */
    protected $quantity;

    /**
     * @var ProductVariantInterface|null
     */
    protected $productVariant;

    /**
     * @var string
     */
    protected $productVariantCode;

    /**
     * @var Money
     */
    protected $price;

    /**
     * @var Money
     */
    protected $convertedPrice;

    /**
     * @var string|null
     */
    protected $reference;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return ProductVariantInterface|null
     */
    public function getProductVariant(): ?ProductVariantInterface
    {
        return $this->productVariant;
    }

    /**
     * @param ProductVariantInterface|null $productVariant
     */
    public function setProductVariant(?ProductVariantInterface $productVariant): void
    {
        $this->productVariantCode = null;
        $this->productVariant = $productVariant;

        if (null !== $productVariant) {
            $this->productVariantCode = $productVariant->getCode();
        }
    }

    /**
     * @return string
     */
    public function getProductVariantCode(): string
    {
        return $this->productVariantCode;
    }

    /**
     * @param string $productVariantCode
     */
    public function setProductVariantCode(string $productVariantCode): void
    {
        $this->productVariantCode = $productVariantCode;
    }

    /**
     * @return Money
     */
    public function getPrice(): Money
    {
        return $this->price;
    }

    /**
     * @param Money $price
     */
    public function setPrice(Money $price): void
    {
        $this->price = $price;
    }

    /**
     * @return Money
     */
    public function getConvertedPrice(): Money
    {
        return $this->convertedPrice;
    }

    /**
     * @param Money $convertedPrice
     */
    public function setConvertedPrice(Money $convertedPrice): void
    {
        $this->convertedPrice = $convertedPrice;
    }

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param string|null $reference
     */
    public function setReference(?string $reference): void
    {
        $this->reference = $reference;
    }
}
