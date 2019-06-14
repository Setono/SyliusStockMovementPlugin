<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Filter;

use Doctrine\ORM\QueryBuilder;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;

final class CreatedAfterFilter extends Filter
{
    /**
     * @throws StringsException
     */
    public function filter(QueryBuilder $queryBuilder, ReportConfigurationInterface $reportConfiguration, array $configuration): void
    {
        $date = $configuration['date'] ?? null;
        if (null === $date) {
            return;
        }

        $alias = $this->getRootAlias($queryBuilder);

        $queryBuilder->andWhere(sprintf('%s.createdAt > :date', $alias))->setParameter('date', $date);
    }
}
