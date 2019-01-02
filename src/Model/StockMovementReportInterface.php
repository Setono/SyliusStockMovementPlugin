<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

use Doctrine\Common\Collections\Collection;

interface StockMovementReportInterface extends ReportInterface
{
    /**
     * @return ReportConfigurationInterface
     */
    public function getReportConfiguration(): ?ReportConfigurationInterface;

    /**
     * @param ReportConfigurationInterface $reportConfiguration
     */
    public function setReportConfiguration(ReportConfigurationInterface $reportConfiguration): void;

    /**
     * @return Collection|StockMovementInterface[]
     */
    public function getStockMovements(): Collection;

    /**
     * @param StockMovementInterface $stockMovement
     */
    public function addStockMovement(StockMovementInterface $stockMovement): void;
}
