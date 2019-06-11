<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Generator;

use Setono\SyliusStockMovementPlugin\DataSource\DataSourceInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class ReportGenerator implements ReportGeneratorInterface
{
    /**
     * @var FactoryInterface
     */
    private $reportFactory;

    /**
     * @var RepositoryInterface
     */
    private $reportRepository;

    /**
     * @var DataSourceInterface
     */
    private $dataSource;

    public function __construct(
        FactoryInterface $reportFactory,
        RepositoryInterface $reportRepository,
        DataSourceInterface $dataSource
    ) {
        $this->reportFactory = $reportFactory;
        $this->reportRepository = $reportRepository;
        $this->dataSource = $dataSource;
    }

    public function generate(ReportConfigurationInterface $reportConfiguration): ?ReportInterface
    {
        // todo somewhere we should add the Setono\SyliusStockMovementPlugin\DataSource\Filter\GreaterThanLatestIdFilter

        /** @var ReportInterface $report */
        $report = $this->reportFactory->createNew();
        $report->setReportConfiguration($reportConfiguration);

        $hasStockMovements = false;

        foreach ($this->dataSource->getData() as $stockMovement) {
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
