<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

class StockMovementReport implements StockMovementReportInterface
{
    use TimestampableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var StockMovementReportConfigurationInterface
     */
    protected $reportConfiguration;

    /**
     * @var StockMovementInterface[]|Collection
     */
    protected $stockMovements;

    public function __construct()
    {
        $this->stockMovements = new ArrayCollection();
    }

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
    public function getReportConfiguration(): ?StockMovementReportConfigurationInterface
    {
        return $this->reportConfiguration;
    }

    /**
     * {@inheritdoc}
     */
    public function setReportConfiguration(StockMovementReportConfigurationInterface $reportConfiguration): void
    {
        $this->reportConfiguration = $reportConfiguration;
    }

    /**
     * {@inheritdoc}
     */
    public function getStockMovements(): Collection
    {
        return $this->stockMovements;
    }

    /**
     * {@inheritdoc}
     */
    public function addStockMovement(StockMovementInterface $stockMovement): void
    {
        $this->stockMovements->add($stockMovement);
    }
}
