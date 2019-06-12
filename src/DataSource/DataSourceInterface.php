<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\DataSource;

use Generator;
use Setono\SyliusStockMovementPlugin\DataSource\Filter\FilterInterface;

interface DataSourceInterface
{
    public function addFilter(FilterInterface $filter): void;

    /**
     * Returns the filtered data
     */
    public function getData(): Generator;
}
