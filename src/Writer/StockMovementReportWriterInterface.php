<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Writer;

use Setono\SyliusStockPlugin\Model\StockMovementReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\StockMovementReportInterface;

interface StockMovementReportWriterInterface
{
    /**
     * Will write a file based on the given report and report configuration
     *
     * @param StockMovementReportInterface $stockMovementReport
     * @param StockMovementReportConfigurationInterface $stockMovementReportConfiguration
     *
     * @return \SplFileInfo
     */
    public function write(StockMovementReportInterface $stockMovementReport, StockMovementReportConfigurationInterface $stockMovementReportConfiguration): \SplFileInfo;
}
