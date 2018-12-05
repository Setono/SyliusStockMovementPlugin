<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

class ReportConfigurationDeliveryMethod implements ReportConfigurationDeliveryMethodInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $configuration;

    /**
     * @var ReportConfigurationInterface|null
     */
    protected $reportConfiguration;

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(): ?array
    {
        return $this->configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfiguration(array $configuration): void
    {
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getReportConfiguration(): ?ReportConfigurationInterface
    {
        return $this->reportConfiguration;
    }

    /**
     * {@inheritdoc}
     */
    public function setReportConfiguration(?ReportConfigurationInterface $reportConfiguration): void
    {
        $this->reportConfiguration = $reportConfiguration;
    }
}
