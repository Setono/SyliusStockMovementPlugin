<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

trait StockMovementReportConfigurationAwareTrait
{
    /**
     * @var StockMovementReportConfigurationInterface
     */
    protected $stockMovementReportConfiguration;

    public function setStockMovementReportConfiguration(StockMovementReportConfigurationInterface $stockMovementReportConfiguration): void
    {
        $this->stockMovementReportConfiguration = $stockMovementReportConfiguration;
    }
}
