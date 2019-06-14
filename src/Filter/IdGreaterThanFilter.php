<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Filter;

use Doctrine\ORM\QueryBuilder;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Repository\ReportRepositoryInterface;

final class IdGreaterThanFilter extends Filter
{
    /** @var ReportRepositoryInterface */
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    /**
     * @throws StringsException
     */
    public function filter(QueryBuilder $queryBuilder, ReportConfigurationInterface $reportConfiguration, array $configuration): void
    {
        $latestId = $configuration['id'] ?? null;
        if (null === $latestId) {
            $latestId = $this->reportRepository->getLatestStockMovementIdOnAReport($reportConfiguration);
            if (null === $latestId) {
                return;
            }
        }

        $alias = $this->getRootAlias($queryBuilder);

        $queryBuilder->andWhere(sprintf('%s.id > :id', $alias))->setParameter('id', $latestId);
    }
}
