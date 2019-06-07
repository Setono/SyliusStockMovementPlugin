<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Transport;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use SplFileInfo;

interface TransportInterface
{
    public function send(SplFileInfo $file, ReportInterface $report, ReportConfigurationInterface $reportConfiguration): void;

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
