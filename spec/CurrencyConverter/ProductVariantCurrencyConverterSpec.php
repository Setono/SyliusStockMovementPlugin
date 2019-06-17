<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\CurrencyConverter;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Currency\Model\CurrencyInterface;

class ProductVariantCurrencyConverterSpec extends CurrencyConverterSpec
{
    public function let(ChannelRepositoryInterface $channelRepository): void
    {
        $this->beConstructedWith($channelRepository);
    }

    public function it_supports_product_variant_conversion_context(ProductVariantInterface $productVariant): void
    {
        $this->supports(10, 'USD', 'EUR', [
            'productVariant' => $productVariant,
        ])->shouldReturn(true);
    }

    public function it_converts(
        ChannelRepositoryInterface $channelRepository,
        ProductVariantInterface $productVariant,
        ChannelPricingInterface $channelPricing1,
        ChannelPricingInterface $channelPricing2,
        ChannelInterface $channel1,
        ChannelInterface $channel2,
        CurrencyInterface $baseCurrency1,
        CurrencyInterface $baseCurrency2
    ): void {
        // setup
        $channelRepository->findOneByCode('channel_1')->willReturn($channel1);
        $channelRepository->findOneByCode('channel_2')->willReturn($channel2);

        $channelPricing1->getChannelCode()->willReturn('channel_1');
        $channelPricing1->getPrice()->willReturn(100);
        $channelPricing2->getChannelCode()->willReturn('channel_2');
        $channelPricing2->getPrice()->willReturn(745);

        $channel1->getBaseCurrency()->willReturn($baseCurrency1);
        $channel2->getBaseCurrency()->willReturn($baseCurrency2);

        $baseCurrency1->getCode()->willReturn('EUR');
        $baseCurrency2->getCode()->willReturn('DKK');

        $productVariant->getChannelPricings()->willReturn(new ArrayCollection([$channelPricing1->getWrappedObject(), $channelPricing2->getWrappedObject()]));

        // test
        $money = $this->convert(10, 'EUR', 'DKK', [
            'productVariant' => $productVariant,
        ]);

        $money->getAmount()->shouldReturn('75');
    }
}
