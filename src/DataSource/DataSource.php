<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\DataSource;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

abstract class DataSource implements DataSourceInterface
{
    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    public function __construct(EntityRepository $repository)
    {
        $this->queryBuilder = $repository->createQueryBuilder('o');
    }

    public function getData(): Pagerfanta
    {
        // Use output walkers option in DoctrineORMAdapter should be false as it affects performance greatly. (see https://github.com/Sylius/Sylius/issues/3775)
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryBuilder, false, false));
        $paginator->setNormalizeOutOfRangePages(true);

        return $paginator;
    }
}
