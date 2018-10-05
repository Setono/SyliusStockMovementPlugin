<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var StockMovementInterface[]
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
