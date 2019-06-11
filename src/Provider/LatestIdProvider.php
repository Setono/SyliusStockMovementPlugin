<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Provider;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
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
    private $reportClass;

    public function __construct(ManagerRegistry $managerRegistry, string $reportClass)
    {
        $this->entityManager = $managerRegistry->getManagerForClass($reportClass);
        $this->reportClass = $reportClass;
    }

    /**
     * {@inheritdoc}
     *
     * @throws NonUniqueResultException
     */
    public function getLatestId(ReportConfigurationInterface $reportConfiguration): int
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('MAX(s.id)')
            ->from($this->reportClass, 'r')
            ->join('r.stockMovements', 's')
            ->andWhere('r.reportConfiguration = :reportConfiguration')
            ->setParameter('reportConfiguration', $reportConfiguration)
        ;

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}
