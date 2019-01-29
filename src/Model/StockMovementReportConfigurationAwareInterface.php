<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

interface StockMovementReportConfigurationAwareInterface
{
    public function setStockMovementReportConfiguration(StockMovementReportConfigurationInterface $stockMovementReportConfiguration): void;
}
