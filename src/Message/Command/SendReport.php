<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Message\Command;

use Setono\SyliusStockMovementPlugin\Model\ReportInterface;

final class SendReport implements CommandInterface
{
    /** @var mixed */
    private $reportId;

    /**
     * @param ReportInterface|mixed $report
     */
    public function __construct($report)
    {
        $this->reportId = $report instanceof ReportInterface ? $report->getId() : $report;
    }

    public function getReportId()
    {
        return $this->reportId;
    }
}
