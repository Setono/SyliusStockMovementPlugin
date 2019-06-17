<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Provider;

use Generator;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\StockMovementInterface;

interface StockMovementProviderInterface
{
    /**
     * Returns the filtered data
     *
     * @return StockMovementInterface[]|Generator
     */
    public function getStockMovements(ReportConfigurationInterface $reportConfiguration): Generator;
}
