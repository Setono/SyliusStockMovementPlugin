<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusStockMovementPlugin\Application\src\DataSource;

use Doctrine\ORM\EntityRepository;
use Setono\SyliusStockMovementPlugin\DataSource\StockMovementDataSource;

final class StockMovementsGreaterThanUSD100DataSource extends StockMovementDataSource
{
    public function __construct(EntityRepository $repository, string $alias = 'o')
    {
        parent::__construct($repository, $alias);

        $this->queryBuilder->andWhere($alias.'.convertedPrice.amount > 10000');
    }
}
