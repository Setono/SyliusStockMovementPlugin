<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusStockPlugin\Application\src\Template;

use Setono\SyliusStockPlugin\Model\StockMovementInterface;
use Setono\SyliusStockPlugin\Template\Template;

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
