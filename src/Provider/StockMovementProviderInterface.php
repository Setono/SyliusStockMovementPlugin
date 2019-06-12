<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Provider;

use Generator;
use Setono\SyliusStockMovementPlugin\Filter\FilterInterface;
use Setono\SyliusStockMovementPlugin\Model\StockMovementInterface;

interface StockMovementProviderInterface
{
    public function addFilter(FilterInterface $filter): void;

    /**
     * Returns the filtered data
     *
     * @return StockMovementInterface[]|Generator
     */
    public function getStockMovements(): Generator;
}
