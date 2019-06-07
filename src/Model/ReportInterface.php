<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface ReportInterface extends ResourceInterface, TimestampableInterface
{
    public function getReportConfiguration(): ?ReportConfigurationInterface;

    public function setReportConfiguration(ReportConfigurationInterface $reportConfiguration): void;

    /**
     * @return Collection|StockMovementInterface[]
     */
    public function getStockMovements(): Collection;

    public function addStockMovement(StockMovementInterface $stockMovement): void;
}
