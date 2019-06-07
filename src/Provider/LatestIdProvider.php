<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Provider;

use Doctrine\ORM\EntityManagerInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;

final class LatestIdProvider implements LatestIdProviderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var string
     */
    private $stockMovementReportClass;

    // todo inject manager registry instead
    public function __construct(EntityManagerInterface $entityManager, string $stockMovementReportClass)
    {
        $this->entityManager = $entityManager;
        $this->stockMovementReportClass = $stockMovementReportClass;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getLatestId(ReportConfigurationInterface $reportConfiguration): int
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('MAX(s.id)')
            ->from($this->stockMovementReportClass, 'r')
            ->join('r.stockMovements', 's')
            ->andWhere('r.reportConfiguration = :reportConfiguration')
            ->setParameter('reportConfiguration', $reportConfiguration)
        ;

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}
