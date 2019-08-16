<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Repository;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * @method ReportInterface[] findAll()
 * @method ?ReportInterface findOneBy(array $criteria)
 * @method ?ReportInterface find($id)
 * @method ?ReportInterface findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
 */
interface ReportRepositoryInterface extends RepositoryInterface
{
    /**
     * If the report configuration is set it will return the latest stock movement id on a report, but where the report
     * has the given report configuration associated
     *
     * Returns 0 if there are no stock movements on the respective reports
     */
    public function getLatestStockMovementIdOnAReport(ReportConfigurationInterface $reportConfiguration = null): int;

    /**
     * Will try to find a report based on the UUID property on the report
     */
    public function findByUuid(string $uuid): ?ReportInterface;
}
