<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\DataSource;

use Pagerfanta\Pagerfanta;

interface DataSourceInterface
{
    /**
     * Will exclude ids less or equal to this id
     *
     * @param int $latestId
     */
    public function guardAgainstLatestId(int $latestId): void;

    /**
     * Returns the filtered data
     *
     * @return Pagerfanta
     */
    public function getData(): Pagerfanta;
}
