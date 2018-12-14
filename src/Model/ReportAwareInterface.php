<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

interface ReportAwareInterface
{
    public function setReport(ReportInterface $report): void;
}
