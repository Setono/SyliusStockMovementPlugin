<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Provider;

use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;

interface ReportConfigurationProviderInterface
{
    /**
     * @return ReportConfigurationInterface[]
     */
    public function getReportConfigurations(): array;
}
