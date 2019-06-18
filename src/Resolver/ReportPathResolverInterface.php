<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Resolver;

use Setono\SyliusStockMovementPlugin\Model\ReportInterface;

interface ReportPathResolverInterface
{
    /**
     * Resolves the report path based on a given report
     */
    public function resolve(ReportInterface $report): string;
}
