<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\DataSource;

use Pagerfanta\Pagerfanta;
use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;

interface DataSourceInterface
{
    /**
     * Returns true if this data filter supports the given report configuration
     *
     * @param ReportConfigurationInterface $reportConfiguration
     *
     * @return bool
     */
    public function supports(ReportConfigurationInterface $reportConfiguration): bool;

    /**
     * Returns the filtered data
     *
     * @return Pagerfanta
     */
    public function getData(): Pagerfanta;
}
