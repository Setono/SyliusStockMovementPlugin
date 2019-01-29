<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

interface StockMovementReportAwareInterface
{
    public function setStockMovementReport(StockMovementReportInterface $report): void;
}
