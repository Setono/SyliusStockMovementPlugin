<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Template;

use Setono\SyliusStockMovementPlugin\Model\ReportAwareInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportAwareTrait;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationAwareInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationAwareTrait;

abstract class Template implements TemplateInterface, ReportAwareInterface, ReportConfigurationAwareInterface
{
    use ReportAwareTrait, ReportConfigurationAwareTrait;

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
