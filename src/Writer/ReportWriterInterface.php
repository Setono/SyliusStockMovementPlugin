<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Writer;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use SplFileInfo;

interface ReportWriterInterface
{
    /**
     * Will write a file based on the given report and report configuration
     *
     * @param ReportInterface $report
     * @param ReportConfigurationInterface $reportConfiguration
     *
     * @return SplFileInfo
     */
    public function write(ReportInterface $report, ReportConfigurationInterface $reportConfiguration): SplFileInfo;
}
