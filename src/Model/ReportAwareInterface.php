<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

interface ReportAwareInterface
{
    public function setStockMovementReport(ReportInterface $report): void;
}
