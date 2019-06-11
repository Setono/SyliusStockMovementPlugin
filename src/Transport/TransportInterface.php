<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Transport;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use SplFileInfo;

interface TransportInterface
{
    public function send(SplFileInfo $file, array $configuration, ReportInterface $report, ReportConfigurationInterface $reportConfiguration): void;
}
