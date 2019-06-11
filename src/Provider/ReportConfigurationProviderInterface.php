<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Provider;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;

interface ReportConfigurationProviderInterface
{
    /**
     * @return ReportConfigurationInterface[]
     */
    public function getReportConfigurations(): array;
}
