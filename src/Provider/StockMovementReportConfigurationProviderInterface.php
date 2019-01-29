<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Provider;

use Setono\SyliusStockPlugin\Model\StockMovementReportConfigurationInterface;

interface StockMovementReportConfigurationProviderInterface
{
    /**
     * @return StockMovementReportConfigurationInterface[]
     */
    public function getStockMovementReportConfigurations(): array;
}
