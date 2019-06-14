<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Filter;

use Doctrine\ORM\QueryBuilder;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;

interface FilterInterface
{
    public function filter(QueryBuilder $queryBuilder, ReportConfigurationInterface $reportConfiguration, array $configuration): void;
}
