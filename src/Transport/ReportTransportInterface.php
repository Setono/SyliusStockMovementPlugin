<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Transport;

use Setono\SyliusStockPlugin\Model\StockMovementReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\StockMovementReportInterface;

interface ReportTransportInterface
{
    /**
     * Will send a report to a given destination
     *
     * @param \SplFileInfo $file
     * @param StockMovementReportInterface $report
     * @param StockMovementReportConfigurationInterface $reportConfiguration
     */
    public function send(\SplFileInfo $file, StockMovementReportInterface $report, StockMovementReportConfigurationInterface $reportConfiguration): void;

    /**
     * Will return true if this transport supports the given report and report configuration
     *
     * @param StockMovementReportInterface $report
     * @param StockMovementReportConfigurationInterface $reportConfiguration
     *
     * @return bool
     */
    public function supports(StockMovementReportInterface $report, StockMovementReportConfigurationInterface $reportConfiguration): bool;
}
