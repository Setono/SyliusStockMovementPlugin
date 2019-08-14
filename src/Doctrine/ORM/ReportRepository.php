<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Doctrine\ORM;

use Doctrine\ORM\NonUniqueResultException;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Repository\ReportRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

final class ReportRepository extends EntityRepository implements ReportRepositoryInterface
{
    /**
     * @throws NonUniqueResultException
     */
    public function getLatestStockMovementIdOnAReport(ReportConfigurationInterface $reportConfiguration = null): int
    {
        $qb = $this->createQueryBuilder('r');
        $qb->select('MAX(s.id)')
            ->join('r.stockMovements', 's')
        ;

        if (null !== $reportConfiguration) {
            $qb->andWhere('r.reportConfiguration = :reportConfiguration')
                ->setParameter('reportConfiguration', $reportConfiguration)
            ;
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}
