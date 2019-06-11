<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\DataSource\Filter;

use Doctrine\ORM\QueryBuilder;
use Webmozart\Assert\Assert;

abstract class Filter implements FilterInterface
{
    protected function getRootAlias(QueryBuilder $queryBuilder): string
    {
        $aliases = $queryBuilder->getRootAliases();
        Assert::count($aliases, 1, 'This filter only supports one root alias at the moment');

        return $aliases[0];
    }
}
