<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Processor;

interface ReportConfigurationProcessorInterface
{
    public function process(): void;
}
