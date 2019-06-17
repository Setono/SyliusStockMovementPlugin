<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Factory;

use Money\Money;
use Setono\SyliusStockMovementPlugin\CurrencyConverter\CurrencyConverterInterface;
use Setono\SyliusStockMovementPlugin\Model\StockMovementInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class StockMovementFactory implements StockMovementFactoryInterface
{
    /** @var FactoryInterface */
    private $decoratedFactory;

    /** @var string */
    private $baseCurrency;

    /** @var CurrencyConverterInterface */
    private $currencyConverter;

    public function __construct(FactoryInterface $decoratedFactory, string $baseCurrency, CurrencyConverterInterface $currencyConverter)
    {
        $this->decoratedFactory = $decoratedFactory;
        $this->baseCurrency = $baseCurrency;
        $this->currencyConverter = $currencyConverter;
    }

    public function createNew(): StockMovementInterface
    {
        /** @var StockMovementInterface $obj */
        $obj = $this->decoratedFactory->createNew();

        return $obj;
    }

    public function createValid(int $quantity, ProductVariantInterface $variant, Money $price, string $reference = null): StockMovementInterface
    {
        $obj = $this->createNew();

        $convertedPrice = $this->currencyConverter->convertFromMoney($price, $this->baseCurrency, [
            'productVariant' => $variant,
        ]);

        $obj->setVariant($variant);
        $obj->setPrice($price);
        $obj->setConvertedPrice($convertedPrice);
        $obj->setQuantity($quantity);
        $obj->setReference($reference);

        return $obj;
    }
}
