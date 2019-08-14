<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Message\Command;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;

final class ProcessReportConfiguration implements CommandInterface
{
    /** @var mixed */
    private $reportConfigurationId;

    /**
     * @param ReportConfigurationInterface|mixed $reportConfiguration
     */
    public function __construct($reportConfiguration)
    {
        $this->reportConfigurationId = $reportConfiguration instanceof ReportConfigurationInterface ? $reportConfiguration->getId() : $reportConfiguration;
    }

    public function getReportConfigurationId()
    {
        return $this->reportConfigurationId;
    }
}
