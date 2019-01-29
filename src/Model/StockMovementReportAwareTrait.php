<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

trait StockMovementReportAwareTrait
{
    /**
     * @var StockMovementReportInterface
     */
    protected $stockMovementReport;

    public function setStockMovementReport(StockMovementReportInterface $stockMovementReport): void
    {
        $this->stockMovementReport = $stockMovementReport;
    }
}
