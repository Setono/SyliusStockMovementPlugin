<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Filter;

use Doctrine\ORM\QueryBuilder;
use Safe\Exceptions\StringsException;
use function Safe\substr;
use Webmozart\Assert\Assert;

abstract class Filter implements FilterInterface
{
    protected function getRootAlias(QueryBuilder $queryBuilder): string
    {
        $aliases = $queryBuilder->getRootAliases();
        Assert::count($aliases, 1, 'This filter only supports one root alias at the moment');

        return $aliases[0];
    }

    /**
     * @throws StringsException
     */
    protected function generateParameterName(string $prefix): string
    {
        return $prefix . '_' . substr(md5(uniqid('', true)), 0, 10);
    }
}
