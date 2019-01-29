<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Provider;

use Setono\SyliusStockPlugin\Model\StockMovementReportConfigurationInterface;
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
        /** @var StockMovementReportConfigurationInterface[] $reportConfigurations */
        $reportConfigurations = $this->reportConfigurationRepository->findAll();

        return array_filter($reportConfigurations, function (StockMovementReportConfigurationInterface $reportConfiguration) {
            $schedule = $reportConfiguration->getSchedule();

            return $schedule !== null && $schedule->isDue();
        });
    }
}
