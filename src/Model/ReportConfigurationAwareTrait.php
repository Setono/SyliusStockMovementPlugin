<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

trait ReportConfigurationAwareTrait
{
    /**
     * @var ReportConfigurationInterface
     */
    protected $reportConfiguration;

    public function setReportConfiguration(ReportConfigurationInterface $reportConfiguration): void
    {
        $this->reportConfiguration = $reportConfiguration;
    }
}
