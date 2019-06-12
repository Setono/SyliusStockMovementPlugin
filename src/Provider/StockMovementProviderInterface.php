<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Provider;

use Generator;
use Setono\SyliusStockMovementPlugin\Filter\FilterInterface;

interface StockMovementProviderInterface
{
    public function addFilter(FilterInterface $filter): void;

    /**
     * Returns the filtered data
     */
    public function getStockMovements(): Generator;
}
