<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Provider;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;

interface LatestIdProviderInterface
{
    /**
     * Returns the latest id that was present in a report with the given report configuration
     */
    public function getLatestId(ReportConfigurationInterface $reportConfiguration): int;
}
