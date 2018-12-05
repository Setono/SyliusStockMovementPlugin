<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface ReportConfigurationDeliveryMethodInterface extends ResourceInterface
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return string|null
     */
    public function getType(): ?string;

    /**
     * @param string $type
     */
    public function setType(string $type): void;

    /**
     * @return array|null
     */
    public function getConfiguration(): ?array;

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration): void;

    /**
     * @return ReportConfigurationInterface|null
     */
    public function getReportConfiguration(): ?ReportConfigurationInterface;

    /**
     * @param ReportConfigurationInterface|null $reportConfiguration
     */
    public function setReportConfiguration(?ReportConfigurationInterface $reportConfiguration): void;
}
