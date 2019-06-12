<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Provider;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Generator;
use InvalidArgumentException;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\SyliusStockMovementPlugin\Filter\FilterInterface;

class StockMovementProvider implements StockMovementProviderInterface
{
    /** @var FilterInterface[] */
    protected $filters = [];

    /** @var ManagerRegistry */
    private $managerRegistry;

    /** @var string */
    private $stockMovementClass;

    public function __construct(ManagerRegistry $managerRegistry, string $stockMovementClass)
    {
        $this->managerRegistry = $managerRegistry;
        $this->stockMovementClass = $stockMovementClass;
    }

    public function addFilter(FilterInterface $filter): void
    {
        $this->filters[] = $filter;
    }

    /**
     * @throws StringsException
     */
    public function getStockMovements(): Generator
    {
        $em = $this->managerRegistry->getManagerForClass($this->stockMovementClass);
        if (!$em instanceof EntityManagerInterface) {
            throw new InvalidArgumentException(sprintf('No manager for class %s', $this->stockMovementClass));
        }

        $qb = $em->createQueryBuilder();
        $qb->select('o')
            ->from($this->stockMovementClass, 'o');

        foreach ($this->filters as $filter) {
            $filter->filter($qb);
        }

        $iterableResult = $qb->getQuery()->iterate();
        foreach ($iterableResult as $row) {
            yield $row[0];

            $em->detach($row[0]);
        }
    }
}
