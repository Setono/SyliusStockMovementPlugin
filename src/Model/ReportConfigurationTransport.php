<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

class ReportConfigurationTransport implements ReportConfigurationTransportInterface
{
    /** @var int */
    protected $id;

    /** @var string|null */
    protected $type;

    /** @var array */
    protected $configuration = [];

    /** @var ReportConfigurationInterface|null */
    protected $reportConfiguration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    public function setConfiguration(array $configuration): void
    {
        $this->configuration = $configuration;
    }

    public function getReportConfiguration(): ?ReportConfigurationInterface
    {
        return $this->reportConfiguration;
    }

    public function setReportConfiguration(?ReportConfigurationInterface $reportConfiguration): void
    {
        $this->reportConfiguration = $reportConfiguration;
    }
}
