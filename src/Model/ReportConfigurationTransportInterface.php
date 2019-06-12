<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface ReportConfigurationTransportInterface extends ResourceInterface, ConfigurableReportConfigurationElementInterface
{
    public function getType(): ?string;

    public function setType(?string $type): void;

    public function getConfiguration(): array;

    public function setConfiguration(array $configuration): void;

    public function getReportConfiguration(): ?ReportConfigurationInterface;

    public function setReportConfiguration(?ReportConfigurationInterface $reportConfiguration): void;
}
