<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Generator;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;

interface ReportGeneratorInterface
{
    /**
     * Will generate a stock movement report based on the report configuration
     * If no eligible stock movements are available it returns null
     *
     * @param ReportConfigurationInterface $reportConfiguration
     *
     * @return ReportInterface|null
     */
    public function generate(ReportConfigurationInterface $reportConfiguration): ?ReportInterface;
}
