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

    /** @var ErrorInterface[]|Collection */
    protected $errors;

    public function __construct()
    {
        $this->stockMovements = new ArrayCollection();
        $this->errors = new ArrayCollection();
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

    public function getErrors(): Collection
    {
        return $this->errors;
    }

    public function addError(ErrorInterface $error): void
    {
        if ($this->hasError($error)) {
            return;
        }

        $this->errors->add($error);
        $error->setReport($this);
    }

    public function hasError(ErrorInterface $error): bool
    {
        return $this->errors->contains($error);
    }
}
