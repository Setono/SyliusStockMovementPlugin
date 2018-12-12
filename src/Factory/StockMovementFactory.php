<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Factory;

use Money\Money;
use Setono\SyliusStockPlugin\CurrencyConverter\CurrencyConverterInterface;
use Setono\SyliusStockPlugin\Model\StockMovementInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class StockMovementFactory implements StockMovementFactoryInterface
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $baseCurrency;

    /**
     * @var CurrencyConverterInterface
     */
    private $currencyConverter;

    public function __construct(string $className, string $baseCurrency, CurrencyConverterInterface $currencyConverter)
    {
        $this->className = $className;
        $this->baseCurrency = $baseCurrency;
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function createNew(): StockMovementInterface
    {
        return new $this->className();
    }

    public function createValid(int $quantity, ProductVariantInterface $productVariant, Money $price, ?string $reference = null): StockMovementInterface
    {
        $convertedPrice = $this->currencyConverter->convertFromMoney($price, $this->baseCurrency);

        /** @var StockMovementInterface $obj */
        $obj = new $this->className();

        $obj->setProductVariant($productVariant);
        $obj->setPrice($price);
        $obj->setQuantity($quantity);
        $obj->setReference($reference);
        $obj->setConvertedPrice($convertedPrice);

        return $obj;
    }
}
