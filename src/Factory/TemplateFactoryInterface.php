<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Factory;

use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\ReportInterface;
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
     * @param ReportInterface $report
     * @param ReportConfigurationInterface $reportConfiguration
     *
     * @return TemplateInterface
     */
    public function createWithReportAndReportConfiguration(
        string $identifier,
        ReportInterface $report,
        ReportConfigurationInterface $reportConfiguration
    ): TemplateInterface;
}
