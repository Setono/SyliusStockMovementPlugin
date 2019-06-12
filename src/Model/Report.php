<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\TimestampableTrait;

class Report implements ReportInterface
{
    use TimestampableTrait;

    /** @var int */
    protected $id;

    /** @var ReportConfigurationInterface */
    protected $reportConfiguration;

    /** @var StockMovementInterface[]|Collection */
    protected $stockMovements;

    public function __construct()
    {
        $this->stockMovements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReportConfiguration(): ?ReportConfigurationInterface
    {
        return $this->reportConfiguration;
    }

    public function setReportConfiguration(ReportConfigurationInterface $reportConfiguration): void
    {
        $this->reportConfiguration = $reportConfiguration;
    }

    public function getStockMovements(): Collection
    {
        return $this->stockMovements;
    }

    public function addStockMovement(StockMovementInterface $stockMovement): void
    {
        $this->stockMovements->add($stockMovement);
    }
}
