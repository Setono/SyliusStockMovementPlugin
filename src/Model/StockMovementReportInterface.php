<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface StockMovementReportInterface extends ResourceInterface, TimestampableInterface
{
    /**
     * @return StockMovementReportConfigurationInterface
     */
    public function getReportConfiguration(): ?StockMovementReportConfigurationInterface;

    /**
     * @param StockMovementReportConfigurationInterface $reportConfiguration
     */
    public function setReportConfiguration(StockMovementReportConfigurationInterface $reportConfiguration): void;

    /**
     * @return Collection|StockMovementInterface[]
     */
    public function getStockMovements(): Collection;

    /**
     * @param StockMovementInterface $stockMovement
     */
    public function addStockMovement(StockMovementInterface $stockMovement): void;
}
