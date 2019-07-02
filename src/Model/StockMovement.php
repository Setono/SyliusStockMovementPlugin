<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

use Money\Money;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

class StockMovement implements StockMovementInterface
{
    use TimestampableTrait;

    /** @var int */
    protected $id;

    /** @var int */
    protected $quantity;

    /** @var ProductVariantInterface|null */
    protected $variant;

    /** @var string */
    protected $variantCode;

    /** @var Money */
    protected $price;

    /** @var Money */
    protected $convertedPrice;

    /** @var string|null */
    protected $reference;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getVariant(): ?ProductVariantInterface
    {
        return $this->variant;
    }

    public function setVariant(?ProductVariantInterface $variant): void
    {
        $this->variant = $variant;

        if (null !== $variant) {
            $this->variantCode = (string) $variant->getCode();
        }
    }

    public function getVariantCode(): ?string
    {
        return $this->variantCode;
    }

    public function setVariantCode(?string $variantCode): void
    {
        $this->variantCode = $variantCode;
    }

    public function getPrice(): ?Money
    {
        return $this->price;
    }

    public function setPrice(Money $price): void
    {
        $this->price = $price;
    }

    public function getConvertedPrice(): ?Money
    {
        return $this->convertedPrice;
    }

    public function setConvertedPrice(Money $convertedPrice): void
    {
        $this->convertedPrice = $convertedPrice;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): void
    {
        $this->reference = $reference;
    }
}
