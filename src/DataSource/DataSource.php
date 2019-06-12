<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\DataSource;

use Doctrine\ORM\EntityRepository;
use Generator;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Setono\SyliusStockMovementPlugin\DataSource\Filter\FilterInterface;

class DataSource implements DataSourceInterface
{
    /** @var FilterInterface[] */
    protected $filters = [];

    /** @var EntityRepository */
    private $repository;

    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function addFilter(FilterInterface $filter): void
    {
        $this->filters[] = $filter;
    }

    public function getData(): Generator
    {
        $qb = $this->repository->createQueryBuilder('o');

        foreach ($this->filters as $filter) {
            $filter->filter($qb);
        }

        // Use output walkers option in DoctrineORMAdapter should be false as it affects performance greatly. (see https://github.com/Sylius/Sylius/issues/3775)
        $paginator = new Pagerfanta(new DoctrineORMAdapter($qb, false, false));
        $paginator->setNormalizeOutOfRangePages(true);

        $paginator->setMaxPerPage(100);
        $pages = $paginator->getNbPages();

        for ($page = 1; $page <= $pages; ++$page) {
            $paginator->setCurrentPage($page);

            yield from $paginator->getCurrentPageResults();
        }
    }
}
