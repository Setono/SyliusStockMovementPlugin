<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Provider;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use InvalidArgumentException;
use Safe\Exceptions\StringsException;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;

final class LatestIdProvider implements LatestIdProviderInterface
{
    /** @var ManagerRegistry */
    private $managerRegistry;

    /** @var string */
    private $reportClass;

    public function __construct(ManagerRegistry $managerRegistry, string $reportClass)
    {
        $this->reportClass = $reportClass;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @throws NonUniqueResultException
     * @throws StringsException
     */
    public function getLatestId(ReportConfigurationInterface $reportConfiguration): int
    {
        /** @var EntityManagerInterface|null $em */
        $em = $this->managerRegistry->getManagerForClass($this->reportClass);
        if (null === $em) {
            throw new InvalidArgumentException(\Safe\sprintf('No manager for class "%s"', $this->reportClass));
        }

        $qb = $em->createQueryBuilder();
        $qb->select('MAX(s.id)')
            ->from($this->reportClass, 'r')
            ->join('r.stockMovements', 's')
            ->andWhere('r.reportConfiguration = :reportConfiguration')
            ->setParameter('reportConfiguration', $reportConfiguration)
        ;

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}
