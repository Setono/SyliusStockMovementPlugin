<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface ReportConfigurationInterface extends ResourceInterface
{
    const TYPE_STOCK_REPORT = 'stock_report';
    const TYPE_STOCK_MOVEMENT_REPORT = 'stock_movement_report';
}
