<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Writer;

use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\ReportInterface;

interface ReportWriterInterface
{
    /**
     * Will write a file based on the given report and report configuration
     *
     * @param ReportInterface $report
     * @param ReportConfigurationInterface $reportConfiguration
     *
     * @return \SplFileInfo
     */
    public function write(ReportInterface $report, ReportConfigurationInterface $reportConfiguration): \SplFileInfo;
}
