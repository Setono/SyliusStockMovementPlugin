<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\CurrencyConverter;

use Money\Currency;
use Money\Money;
use Safe\Exceptions\StringsException;
use Setono\SyliusStockMovementPlugin\Exception\CurrencyConversionException;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class ProductVariantCurrencyConverter extends CurrencyConverter
{
    /** @var ChannelRepositoryInterface */
    private $channelRepository;

    public function __construct(ChannelRepositoryInterface $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }

    /**
     * @throws StringsException
     */
    public function convert(int $amount, string $sourceCurrency, string $targetCurrency, array $conversionContext = []): Money
    {
        /** @var ProductVariantInterface $productVariant */
        $productVariant = $conversionContext['productVariant'];

        $productVariantSourceAmount = $productVariantTargetAmount = null;

        foreach ($productVariant->getChannelPricings() as $channelPricing) {
            /** @var ChannelInterface|null $channel */
            $channel = $this->channelRepository->findOneByCode($channelPricing->getChannelCode());
            if (null === $channel) {
                continue;
            }

            $baseCurrency = $channel->getBaseCurrency();
            if (null === $baseCurrency) {
                continue;
            }

            $baseCurrencyCode = $baseCurrency->getCode();
            if (null === $baseCurrencyCode) {
                continue;
            }

            if ($sourceCurrency === $baseCurrencyCode) {
                $productVariantSourceAmount = $channelPricing->getPrice();
            } elseif ($targetCurrency === $baseCurrencyCode) {
                $productVariantTargetAmount = $channelPricing->getPrice();
            }
        }

        if (null === $productVariantSourceAmount || null === $productVariantTargetAmount) {
            throw new CurrencyConversionException($amount, $sourceCurrency, $targetCurrency, $conversionContext);
        }

        $exchangeRate = $productVariantSourceAmount / $productVariantTargetAmount;

        $convertedAmount = round($amount / $exchangeRate);

        return new Money((int) $convertedAmount, new Currency($targetCurrency));
    }

    public function supports(int $amount, string $sourceCurrency, string $targetCurrency, array $conversionContext = []): bool
    {
        if (!isset($conversionContext['productVariant'])) {
            return false;
        }

        $productVariant = $conversionContext['productVariant'];
        if (!$productVariant instanceof ProductVariantInterface) {
            return false;
        }

        // we can never compute an exchange rate if the variant doesn't have two or more channel prices
        if ($productVariant->getChannelPricings()->count() <= 1) {
            return false;
        }

        return true;
    }
}
