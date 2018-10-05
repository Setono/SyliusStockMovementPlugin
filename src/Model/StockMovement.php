<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

class StockMovement
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
     * @var string|null
     */
    protected $reference;
}
