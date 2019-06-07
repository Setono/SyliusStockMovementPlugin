<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

interface ReportConfigurationAwareInterface
{
    public function setStockMovementReportConfiguration(ReportConfigurationInterface $stockMovementReportConfiguration): void;
}
