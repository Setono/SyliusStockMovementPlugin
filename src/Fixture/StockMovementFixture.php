<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\Biased;
use Setono\SyliusStockMovementPlugin\Factory\StockMovementFactoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class StockMovementFixture extends AbstractFixture
{
    /** @var StockMovementFactoryInterface */
    private $stockMovementFactory;

    /** @var ObjectManager */
    private $stockMovementManager;

    /** @var ProductVariantRepositoryInterface */
    private $productVariantRepository;

    /** @var Generator */
    private $faker;

    public function __construct(
        StockMovementFactoryInterface $stockMovementFactory,
        ObjectManager $stockMovementManager,
        ProductVariantRepositoryInterface $productVariantRepository
    ) {
        $this->stockMovementFactory = $stockMovementFactory;
        $this->stockMovementManager = $stockMovementManager;
        $this->productVariantRepository = $productVariantRepository;

        $this->faker = Factory::create();
    }

    public function getName(): string
    {
        return 'setono_stock_movement';
    }

    public function load(array $options): void
    {
        $productVariants = $this->productVariantRepository->findAll();

        for ($i = 0; $i < $options['amount']; ++$i) {
            do {
                $quantity = (int) $this->faker->biasedNumberBetween(-10, 10, [Biased::class, 'linearLow']);
            } while (0 === $quantity);

            $productVariant = $this->faker->randomElement($productVariants);
            $reference = $this->faker->text(40);

            $stockMovement = $this->stockMovementFactory->createValid($quantity, $productVariant, $reference);

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
}
