<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\DataFilter;

use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;

abstract class StockMovementDataFilter extends DataFilter
{
    public function supports(ReportConfigurationInterface $reportConfiguration): bool
    {
        return $reportConfiguration->getType() === ReportConfigurationInterface::TYPE_STOCK_MOVEMENT;
    }
}
