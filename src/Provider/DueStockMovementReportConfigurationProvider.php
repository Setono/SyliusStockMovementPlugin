<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Provider;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class DueStockMovementReportConfigurationProvider implements StockMovementReportConfigurationProviderInterface
{
    /**
     * @var RepositoryInterface
     */
    private $reportConfigurationRepository;

    public function __construct(RepositoryInterface $reportConfigurationRepository)
    {
        $this->reportConfigurationRepository = $reportConfigurationRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getStockMovementReportConfigurations(): array
    {
        /** @var ReportConfigurationInterface[] $reportConfigurations */
        $reportConfigurations = $this->reportConfigurationRepository->findAll();

        return array_filter($reportConfigurations, function (ReportConfigurationInterface $reportConfiguration) {
            $schedule = $reportConfiguration->getSchedule();

            return $schedule !== null && $schedule->isDue();
        });
    }
}
