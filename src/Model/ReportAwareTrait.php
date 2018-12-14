<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

trait ReportAwareTrait
{
    /**
     * @var ReportInterface
     */
    protected $report;

    public function setReport(ReportInterface $report): void
    {
        $this->report = $report;
    }
}
