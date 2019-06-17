<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Generator;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Setono\SyliusStockMovementPlugin\Provider\StockMovementProviderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class ReportGenerator implements ReportGeneratorInterface
{
    /** @var FactoryInterface */
    private $reportFactory;

    /** @var RepositoryInterface */
    private $reportRepository;

    /** @var StockMovementProviderInterface */
    private $stockMovementProvider;

    public function __construct(
        FactoryInterface $reportFactory,
        RepositoryInterface $reportRepository,
        StockMovementProviderInterface $stockMovementProvider
    ) {
        $this->reportFactory = $reportFactory;
        $this->reportRepository = $reportRepository;
        $this->stockMovementProvider = $stockMovementProvider;
    }

    public function generate(ReportConfigurationInterface $reportConfiguration): ?ReportInterface
    {
        /** @var ReportInterface $report */
        $report = $this->reportFactory->createNew();
        $report->setReportConfiguration($reportConfiguration);

        $hasStockMovements = false;

        foreach ($this->stockMovementProvider->getStockMovements($reportConfiguration) as $stockMovement) {
            $report->addStockMovement($stockMovement);

            $hasStockMovements = true;
        }

        if (!$hasStockMovements) {
            return null;
        }

        $this->reportRepository->add($report);

        return $report;
    }
}
