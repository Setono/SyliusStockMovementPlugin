<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Provider;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\SyliusStockMovementPlugin\Filter\FilterInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\StockMovementInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

class StockMovementProvider implements StockMovementProviderInterface
{
    /** @var ServiceRegistryInterface */
    private $filterRegistry;

    /** @var ManagerRegistry */
    private $managerRegistry;

    /** @var string */
    private $stockMovementClass;

    public function __construct(ServiceRegistryInterface $filterRegistry, ManagerRegistry $managerRegistry, string $stockMovementClass)
    {
        $this->filterRegistry = $filterRegistry;
        $this->managerRegistry = $managerRegistry;
        $this->stockMovementClass = $stockMovementClass;
    }

    /**
     * @return StockMovementInterface[]|iterable
     *
     * @throws StringsException
     */
    public function getStockMovements(ReportConfigurationInterface $reportConfiguration): iterable
    {
        $em = $this->managerRegistry->getManagerForClass($this->stockMovementClass);
        if (!$em instanceof EntityManagerInterface) {
            throw new InvalidArgumentException(sprintf('No manager for class %s', $this->stockMovementClass));
        }

        $qb = $em->createQueryBuilder();
        $qb->select('o')
            ->from($this->stockMovementClass, 'o')
        ;

        foreach ($reportConfiguration->getFilters() as $reportConfigurationFilter) {
            /** @var FilterInterface $filter */
            $filter = $this->filterRegistry->get($reportConfigurationFilter->getType());

            $filter->filter($qb, $reportConfiguration, $reportConfigurationFilter->getConfiguration());
        }

        $iterableResult = $qb->getQuery()->iterate();
        foreach ($iterableResult as $row) {
            yield $row[0];
        }
    }
}
