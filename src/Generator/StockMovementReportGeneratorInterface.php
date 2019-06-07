<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Generator;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;

interface StockMovementReportGeneratorInterface
{
    /**
     * Will generate a stock movement report based on the report configuration
     * If no eligible stock movements are available it returns null
     *
     * @param ReportConfigurationInterface $stockMovementReportConfiguration
     *
     * @return ReportInterface|null
     */
    public function generate(ReportConfigurationInterface $stockMovementReportConfiguration): ?ReportInterface;
}
