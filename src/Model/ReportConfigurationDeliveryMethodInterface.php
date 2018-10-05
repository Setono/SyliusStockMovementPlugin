<?php

namespace Setono\SyliusStockPlugin\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface ReportConfigurationDeliveryMethodInterface extends ResourceInterface
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return null|string
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
     * @return null|ReportConfigurationInterface
     */
    public function getReportConfiguration(): ?ReportConfigurationInterface;

    /**
     * @param null|ReportConfigurationInterface $reportConfiguration
     */
    public function setReportConfiguration(?ReportConfigurationInterface $reportConfiguration): void;
}