<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Filter;

use Doctrine\ORM\QueryBuilder;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;

final class IdGreaterThanFilter extends Filter
{
    /** @var int */
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @throws StringsException
     */
    public function filter(QueryBuilder $queryBuilder): void
    {
        $alias = $this->getRootAlias($queryBuilder);

        $queryBuilder->andWhere(sprintf('%s.id > :id', $alias))->setParameter('id', $this->id);
    }
}
