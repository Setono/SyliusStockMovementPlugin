<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Provider;

use Setono\SyliusStockPlugin\Model\StockMovementReportConfigurationInterface;

interface LatestIdProviderInterface
{
    /**
     * Returns the latest id that was present in a report with the given report configuration
     *
     * @param StockMovementReportConfigurationInterface $reportConfiguration
     *
     * @return int
     */
    public function getLatestId(StockMovementReportConfigurationInterface $reportConfiguration): int;
}
