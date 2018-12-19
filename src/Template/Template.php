<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Template;

use Setono\SyliusStockPlugin\Model\ReportAwareInterface;
use Setono\SyliusStockPlugin\Model\ReportAwareTrait;
use Setono\SyliusStockPlugin\Model\ReportConfigurationAwareInterface;
use Setono\SyliusStockPlugin\Model\ReportConfigurationAwareTrait;

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

        return 'report-' . $this->report->getId() . '---' . $now->format('YmdHis.u');
    }

    public function renderItems(): \Generator
    {
        foreach ($this->report->getItems() as $item) {
            yield $this->renderItem($item);
        }
    }

    abstract protected function renderItem($item): string;
}
