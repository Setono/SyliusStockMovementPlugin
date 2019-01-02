<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\DataSource;

use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;

abstract class StockMovementDataSource extends DataSource
{
    public function supports(ReportConfigurationInterface $reportConfiguration): bool
    {
        return $reportConfiguration->getType() === ReportConfigurationInterface::TYPE_STOCK_MOVEMENT;
    }
}
