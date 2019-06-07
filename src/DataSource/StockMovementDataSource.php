<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\DataSource;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

abstract class StockMovementDataSource implements DataSourceInterface
{
    /**
     * @var string
     */
    private $alias;

    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    public function __construct(EntityRepository $repository, string $alias = 'o')
    {
        $this->alias = $alias;

        $this->queryBuilder = $repository->createQueryBuilder($this->alias);
    }

    public function guardAgainstLatestId(int $latestId): void
    {
        $this->queryBuilder->andWhere($this->alias . '.id > ' . $latestId);
    }

    public function getData(): Pagerfanta
    {
        // Use output walkers option in DoctrineORMAdapter should be false as it affects performance greatly. (see https://github.com/Sylius/Sylius/issues/3775)
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryBuilder, false, false));
        $paginator->setNormalizeOutOfRangePages(true);

        return $paginator;
    }
}
