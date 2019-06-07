<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Form\EventListener;

use Setono\SyliusStockMovementPlugin\CurrencyConverter\CurrencyConverterInterface;
use Setono\SyliusStockMovementPlugin\Model\StockMovementInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Webmozart\Assert\Assert;

final class ConvertPriceListener implements EventSubscriberInterface
{
    /**
     * @var CurrencyConverterInterface
     */
    private $currencyConverter;

    /**
     * @var string
     */
    private $baseCurrency;

    public function __construct(CurrencyConverterInterface $currencyConverter, string $baseCurrency)
    {
        $this->currencyConverter = $currencyConverter;
        $this->baseCurrency = $baseCurrency;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SUBMIT => ['onPostSubmit', 256], // the priority is set because we want this to run before the validation
        ];
    }

    public function onPostSubmit(FormEvent $event): void
    {
        /** @var StockMovementInterface $stockMovement */
        $stockMovement = $event->getData();

        Assert::isInstanceOf($stockMovement, StockMovementInterface::class);

        $price = $stockMovement->getPrice();

        if (null === $price) {
            return;
        }

        $stockMovement->setConvertedPrice($this->currencyConverter->convertFromMoney($price, $this->baseCurrency));
    }
}
