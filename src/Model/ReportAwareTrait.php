<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

trait ReportAwareTrait
{
    /**
     * @var ReportInterface
     */
    protected $stockMovementReport;

    public function setStockMovementReport(ReportInterface $stockMovementReport): void
    {
        $this->stockMovementReport = $stockMovementReport;
    }
}
