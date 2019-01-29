<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Generator;

use Setono\SyliusStockPlugin\Model\StockMovementReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\StockMovementReportInterface;

interface StockMovementReportGeneratorInterface
{
    /**
     * Will generate a stock movement report based on the report configuration
     * If no eligible stock movements are available it returns null
     *
     * @param StockMovementReportConfigurationInterface $stockMovementReportConfiguration
     *
     * @return StockMovementReportInterface|null
     */
    public function generate(StockMovementReportConfigurationInterface $stockMovementReportConfiguration): ?StockMovementReportInterface;
}
