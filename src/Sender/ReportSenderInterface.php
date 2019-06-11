<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Sender;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use SplFileInfo;

interface ReportSenderInterface
{
    public function send(SplFileInfo $file, ReportInterface $report, ReportConfigurationInterface $reportConfiguration): void;
}
