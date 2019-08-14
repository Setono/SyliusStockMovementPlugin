<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Provider;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class DueReportConfigurationProvider implements ReportConfigurationProviderInterface
{
    /** @var RepositoryInterface */
    private $reportConfigurationRepository;

    public function __construct(RepositoryInterface $reportConfigurationRepository)
    {
        $this->reportConfigurationRepository = $reportConfigurationRepository;
    }

    public function getReportConfigurations(): array
    {
        /** @var ReportConfigurationInterface[] $reportConfigurations */
        $reportConfigurations = $this->reportConfigurationRepository->findAll();

        // notice that array keys are preserved when using array_filter (https://www.php.net/array_filter)
        return array_filter($reportConfigurations, static function (ReportConfigurationInterface $reportConfiguration) {
            $schedule = $reportConfiguration->getSchedule();

            return $schedule !== null && $schedule->isDue();
        });
    }
}
