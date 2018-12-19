<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Transport;

use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\ReportInterface;

interface ReportTransportInterface
{
    /**
     * Will send a report to a given destination
     *
     * @param \SplFileInfo $file
     * @param ReportInterface $report
     * @param ReportConfigurationInterface $reportConfiguration
     */
    public function send(\SplFileInfo $file, ReportInterface $report, ReportConfigurationInterface $reportConfiguration): void;

    /**
     * Will return true if this transport supports the given report and report configuration
     *
     * @param ReportInterface $report
     * @param ReportConfigurationInterface $reportConfiguration
     *
     * @return bool
     */
    public function supports(ReportInterface $report, ReportConfigurationInterface $reportConfiguration): bool;
}
