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
     * @var int
     */
    protected $quantity;

    /**
     * @var ProductVariantInterface|null
     */
    protected $variant;

    /**
     * @var string
     */
    protected $variantCode;

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
    public function getQuantity(): ?int
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
    public function getVariant(): ?ProductVariantInterface
    {
        return $this->variant;
    }

    /**
     * @param ProductVariantInterface|null $variant
     */
    public function setVariant(?ProductVariantInterface $variant): void
    {
        $this->variant = $variant;

        if (null !== $variant) {
            $this->variantCode = (string) $variant->getCode();
        }
    }

    /**
     * @return string
     */
    public function getVariantCode(): ?string
    {
        return $this->variantCode;
    }

    /**
     * @param string $variantCode
     */
    public function setVariantCode(string $variantCode): void
    {
        $this->variantCode = $variantCode;
    }

    /**
     * @return Money
     */
    public function getPrice(): ?Money
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
    public function getConvertedPrice(): ?Money
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
