<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusStockMovementPlugin\Application\src\Template;

use Setono\SyliusStockMovementPlugin\Model\StockMovementInterface;
use Setono\SyliusStockMovementPlugin\Template\Template;

class TestTemplate extends Template
{
    public function getFilename(): string
    {
        return parent::getFilename().'.txt';
    }

    /**
     * @param StockMovementInterface $item
     * @return string
     */
    protected function renderItem($item): string
    {
        return $item->getQuantity().';'.$item->getVariantCode().';'.$item->getConvertedPrice()->getCurrency()->getCode().' '.$item->getConvertedPrice()->getAmount()."\n";
    }
}
