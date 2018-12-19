<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Generator;

use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\ReportInterface;
use Setono\SyliusStockPlugin\Model\StockMovement;
use Setono\SyliusStockPlugin\Model\StockMovementReport;
use Webmozart\Assert\Assert;

class StockMovementReportGenerator implements StockMovementReportGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate(ReportConfigurationInterface $reportConfiguration): ReportInterface
    {
        Assert::eq($reportConfiguration->getType(), ReportConfigurationInterface::TYPE_STOCK_MOVEMENT);

        $report = new StockMovementReport();
        $report->addStockMovement(new StockMovement());
        $report->addStockMovement(new StockMovement());

        return $report;
    }
}
