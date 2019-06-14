<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Message\Command;

class ProcessReportConfiguration
{
    /** @var mixed */
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
