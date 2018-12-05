<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\TimestampableTrait;

class StockMovementReport implements StockMovementInterface
{
    use TimestampableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var ReportConfigurationInterface
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

    public function getId(): ?int
    {
        return $this->id;
    }
}
