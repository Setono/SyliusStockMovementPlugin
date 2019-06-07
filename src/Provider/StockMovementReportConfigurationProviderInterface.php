<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Provider;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;

interface StockMovementReportConfigurationProviderInterface
{
    /**
     * @return ReportConfigurationInterface[]
     */
    public function getStockMovementReportConfigurations(): array;
}
