<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Generator;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Setono\SyliusStockMovementPlugin\Provider\StockMovementProviderInterface;
use Setono\SyliusStockMovementPlugin\Validator\ReportValidatorInterface;
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

    /** @var ReportValidatorInterface */
    private $reportValidator;

    public function __construct(
        FactoryInterface $reportFactory,
        RepositoryInterface $reportRepository,
        StockMovementProviderInterface $stockMovementProvider,
        ReportValidatorInterface $reportValidator
    ) {
        $this->reportFactory = $reportFactory;
        $this->reportRepository = $reportRepository;
        $this->stockMovementProvider = $stockMovementProvider;
        $this->reportValidator = $reportValidator;
    }

    public function generate(ReportConfigurationInterface $reportConfiguration): ?ReportInterface
    {
        /** @var ReportInterface $report */
        $report = $this->reportFactory->createNew();
        $report->setReportConfiguration($reportConfiguration);

        foreach ($this->stockMovementProvider->getStockMovements($reportConfiguration) as $stockMovement) {
            $report->addStockMovement($stockMovement);
        }

        if ($report->getStockMovements()->count() === 0) {
            return null;
        }

        $this->reportValidator->validate($report);

        $this->reportRepository->add($report);

        return $report;
    }
}
