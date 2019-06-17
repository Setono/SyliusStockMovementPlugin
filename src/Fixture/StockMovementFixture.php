<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\Biased;
use Money\Currency;
use Money\Money;
use Setono\SyliusStockMovementPlugin\Factory\StockMovementFactoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Sylius\Component\Currency\Model\CurrencyInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class StockMovementFixture extends AbstractFixture
{
    /** @var StockMovementFactoryInterface */
    private $stockMovementFactory;

    /** @var ObjectManager */
    private $stockMovementManager;

    /** @var ProductVariantRepositoryInterface */
    private $productVariantRepository;

    /** @var RepositoryInterface */
    private $currencyRepository;

    /** @var Generator */
    private $faker;

    public function __construct(
        StockMovementFactoryInterface $stockMovementFactory,
        ObjectManager $stockMovementManager,
        ProductVariantRepositoryInterface $productVariantRepository,
        RepositoryInterface $currencyRepository
    ) {
        $this->stockMovementFactory = $stockMovementFactory;
        $this->stockMovementManager = $stockMovementManager;
        $this->productVariantRepository = $productVariantRepository;
        $this->currencyRepository = $currencyRepository;

        $this->faker = Factory::create();
    }

    public function getName(): string
    {
        return 'setono_stock_movement';
    }

    public function load(array $options): void
    {
        $productVariants = $this->productVariantRepository->findAll();
        $currencies = $this->currencyRepository->findAll();

        for ($i = 0; $i < $options['amount']; ++$i) {
            $quantity = (int) $this->faker->biasedNumberBetween(0, 10, [Biased::class, 'linearLow']);
            $productVariant = $this->faker->randomElement($productVariants);
            $currency = $this->faker->randomElement($currencies);
            $price = $this->generatePrice($currency);
            $reference = $this->faker->text();

            $stockMovement = $this->stockMovementFactory->createValid($quantity, $productVariant, $price, $reference);

            $this->stockMovementManager->persist($stockMovement);

            if (0 === ($i % 50)) {
                $this->stockMovementManager->flush();
            }
        }

        $this->stockMovementManager->flush();
    }

    protected function configureOptionsNode(ArrayNodeDefinition $resourceNode): void
    {
        $resourceNode
            ->children()
                ->integerNode('amount')->min(1)->isRequired()->end()
            ->end()
        ;
    }

    private function generatePrice(CurrencyInterface $currency): Money
    {
        $amount = $this->faker->numberBetween(100, 10000);

        return new Money($amount, new Currency($currency->getCode()));
    }
}
