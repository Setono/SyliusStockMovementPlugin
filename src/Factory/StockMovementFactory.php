<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Factory;

use Money\Money;
use Setono\SyliusStockPlugin\CurrencyConverter\CurrencyConverterInterface;
use Setono\SyliusStockPlugin\Model\StockMovementInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class StockMovementFactory implements StockMovementFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $decoratedFactory;

    /**
     * @var string
     */
    private $baseCurrency;

    /**
     * @var CurrencyConverterInterface
     */
    private $currencyConverter;

    public function __construct(FactoryInterface $decoratedFactory, string $baseCurrency, CurrencyConverterInterface $currencyConverter)
    {
        $this->decoratedFactory = $decoratedFactory;
        $this->baseCurrency = $baseCurrency;
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function createNew(): StockMovementInterface
    {
        /** @var StockMovementInterface $obj */
        $obj = $this->decoratedFactory->createNew();

        return $obj;
    }

    public function createValid(int $quantity, ProductVariantInterface $variant, Money $price, ?string $reference = null): StockMovementInterface
    {
        $obj = $this->createNew();

        $convertedPrice = $this->currencyConverter->convertFromMoney($price, $this->baseCurrency);

        $obj->setVariant($variant);
        $obj->setPrice($price);
        $obj->setQuantity($quantity);
        $obj->setReference($reference);
        $obj->setConvertedPrice($convertedPrice);

        return $obj;
    }
}
