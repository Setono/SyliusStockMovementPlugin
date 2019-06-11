<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\DataSource\Filter;

use DateTimeInterface;
use Doctrine\ORM\QueryBuilder;

final class CreatedAfterFilter extends Filter
{
    /**
     * @var DateTimeInterface
     */
    private $dateTime;

    public function __construct(DateTimeInterface $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function filter(QueryBuilder $queryBuilder): void
    {
        $alias = $this->getRootAlias($queryBuilder);

        $queryBuilder->andWhere(sprintf('%s.createdAt > :date', $alias))->setParameter('date', $this->dateTime);
    }
}
