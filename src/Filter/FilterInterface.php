<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Filter;

use Doctrine\ORM\QueryBuilder;

interface FilterInterface
{
    public function filter(QueryBuilder $queryBuilder): void;
}
