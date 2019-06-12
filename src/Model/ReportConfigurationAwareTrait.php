<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

trait ReportConfigurationAwareTrait
{
    /** @var ReportConfigurationInterface */
    protected $stockMovementReportConfiguration;

    public function setStockMovementReportConfiguration(ReportConfigurationInterface $stockMovementReportConfiguration): void
    {
        $this->stockMovementReportConfiguration = $stockMovementReportConfiguration;
    }
}
