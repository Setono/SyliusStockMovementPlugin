<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface ConfigurableReportConfigurationElementInterface extends ResourceInterface
{
    public function getType(): ?string;

    public function getConfiguration(): array;

    public function getReportConfiguration(): ?ReportConfigurationInterface;
}
