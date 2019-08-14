<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Repository;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface ReportRepositoryInterface extends RepositoryInterface
{
    /**
     * If the report configuration is set it will return the latest stock movement id on a report, but where the report
     * has the given report configuration associated
     *
     * Returns 0 if there are no stock movements on the respective reports
     */
    public function getLatestStockMovementIdOnAReport(ReportConfigurationInterface $reportConfiguration = null): int;
}
