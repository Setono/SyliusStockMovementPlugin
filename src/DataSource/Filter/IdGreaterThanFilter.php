<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\DataSource\Filter;

use Doctrine\ORM\QueryBuilder;

final class IdGreaterThanFilter extends Filter
{
    /**
     * @var int
     */
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function filter(QueryBuilder $queryBuilder): void
    {
        $alias = $this->getRootAlias($queryBuilder);

        $queryBuilder->andWhere(sprintf('%s.id > :id', $alias))->setParameter('id', $this->id);
    }
}
