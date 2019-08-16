<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusStockMovementPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Setono\SyliusStockMovementPlugin\Factory\StockMovementFactoryInterface;
use Setono\SyliusStockMovementPlugin\Model\StockMovementInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class StockMovementContext implements Context
{
    /**
     * @var FactoryInterface
     */
    private $stockMovementFactory;

    /**
     * @var RepositoryInterface
     */
    private $stockMovementRepository;

    public function __construct(StockMovementFactoryInterface $stockMovementFactory, RepositoryInterface $stockMovementRepository)
    {
        $this->stockMovementFactory = $stockMovementFactory;
        $this->stockMovementRepository = $stockMovementRepository;
    }

    /**
     * @Given there are stock movements
     */
    public function aReportConfigurationIsDue(): void
    {
        for($i = 0; $i < 10; $i++) {
            /** @var StockMovementInterface $stockMovement */
            $stockMovement = $this->stockMovementFactory->createNew();

            $stockMovement->setQuantity($i + 1);
            $stockMovement->setVariantCode('variant-code-'.$i);

            $this->stockMovementRepository->add($stockMovement);
        }

    }
}
