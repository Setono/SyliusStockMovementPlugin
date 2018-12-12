<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Template;

use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\ReportInterface;

abstract class Template implements TemplateInterface
{
    /**
     * @var ReportInterface
     */
    protected $report;

    /**
     * @var ReportConfigurationInterface
     */
    protected $reportConfiguration;

    public function __construct(ReportInterface $report, ReportConfigurationInterface $reportConfiguration)
    {
        $this->report = $report;
        $this->reportConfiguration = $reportConfiguration;
    }
}
