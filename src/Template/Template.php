<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Template;

use Setono\SyliusStockPlugin\Model\StockMovementReportAwareInterface;
use Setono\SyliusStockPlugin\Model\StockMovementReportAwareTrait;
use Setono\SyliusStockPlugin\Model\StockMovementReportConfigurationAwareInterface;
use Setono\SyliusStockPlugin\Model\StockMovementReportConfigurationAwareTrait;

abstract class Template implements TemplateInterface, StockMovementReportAwareInterface, StockMovementReportConfigurationAwareInterface
{
    use StockMovementReportAwareTrait, StockMovementReportConfigurationAwareTrait;

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function getFilename(): string
    {
        $now = new \DateTime();

        return 'report-' . $this->stockMovementReport->getId() . '---' . $now->format('YmdHis.u');
    }

    public function renderHeader(): string
    {
        return '';
    }

    public function renderFooter(): string
    {
        return '';
    }

    public function renderItems(): \Generator
    {
        foreach ($this->stockMovementReport->getStockMovements() as $stockMovement) {
            yield $this->renderItem($stockMovement);
        }
    }

    abstract protected function renderItem($item): string;
}
