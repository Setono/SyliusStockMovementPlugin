<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Transport;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;

interface TransportInterface
{
    public function send(string $file, array $configuration, ReportInterface $report, ReportConfigurationInterface $reportConfiguration): void;
}
