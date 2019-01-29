<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Factory;

use Setono\SyliusStockPlugin\Model\StockMovementReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\StockMovementReportInterface;
use Setono\SyliusStockPlugin\Template\TemplateInterface;

interface TemplateFactoryInterface
{
    /**
     * Creates a template
     *
     * @param string $identifier
     *
     * @return TemplateInterface
     */
    public function create(string $identifier): TemplateInterface;

    /**
     * Creates a template with a report and report configuration set
     *
     * @param string $identifier
     * @param StockMovementReportInterface $report
     * @param StockMovementReportConfigurationInterface $reportConfiguration
     *
     * @return TemplateInterface
     */
    public function createWithReportAndReportConfiguration(
        string $identifier,
        StockMovementReportInterface $report,
        StockMovementReportConfigurationInterface $reportConfiguration
    ): TemplateInterface;
}
