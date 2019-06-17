<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Processor;

use Psr\Log\LoggerAwareInterface;

interface ReportConfigurationProcessorInterface extends LoggerAwareInterface
{
    public function process(): void;
}
