<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Writer;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;

interface StockMovementReportWriterInterface
{
    /**
     * Will write a file based on the given report and report configuration
     *
     * @param ReportInterface $stockMovementReport
     * @param ReportConfigurationInterface $stockMovementReportConfiguration
     *
     * @return \SplFileInfo
     */
    public function write(ReportInterface $stockMovementReport, ReportConfigurationInterface $stockMovementReportConfiguration): \SplFileInfo;
}
