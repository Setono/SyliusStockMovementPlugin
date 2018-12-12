<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Generator;

use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\ReportInterface;

interface ReportGeneratorInterface
{
    /**
     * Will generate a report based on the report configuration
     *
     * @param ReportConfigurationInterface $reportConfiguration
     *
     * @return ReportInterface
     */
    public function generate(ReportConfigurationInterface $reportConfiguration): ReportInterface;
}
