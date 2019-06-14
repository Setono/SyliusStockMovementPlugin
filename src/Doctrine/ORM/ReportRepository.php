<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Doctrine\ORM;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Repository\ReportRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

final class ReportRepository extends EntityRepository implements ReportRepositoryInterface
{
    public function getLatestStockMovementIdOnAReport(ReportConfigurationInterface $reportConfiguration = null): ?int
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

        $res = $qb->getQuery()->getSingleScalarResult();
        if (null === $res) {
            return null;
        }

        return (int) $res;
    }
}
