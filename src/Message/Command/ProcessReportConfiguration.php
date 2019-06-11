<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Message\Command;

class ProcessReportConfiguration
{
    private $reportConfigurationId;

    public function __construct($reportConfigurationId)
    {
        $this->reportConfigurationId = $reportConfigurationId;
    }

    public function getReportConfigurationId()
    {
        return $this->reportConfigurationId;
    }
}
