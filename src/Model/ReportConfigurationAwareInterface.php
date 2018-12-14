<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

interface ReportConfigurationAwareInterface
{
    public function setReportConfiguration(ReportConfigurationInterface $reportConfiguration): void;
}
