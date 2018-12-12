<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Generator;

use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\ReportInterface;

final class ReportGenerator implements ReportGeneratorInterface
{
    /**
     * @var StockMovementReportGeneratorInterface
     */
    private $stockMovementReportGenerator;

    public function __construct(StockMovementReportGeneratorInterface $stockMovementReportGenerator)
    {
        $this->stockMovementReportGenerator = $stockMovementReportGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(ReportConfigurationInterface $reportConfiguration): ReportInterface
    {
        if ($reportConfiguration->getType() === ReportConfigurationInterface::TYPE_STOCK_MOVEMENT) {
            return $this->stockMovementReportGenerator->generate($reportConfiguration);
        }

        throw new \InvalidArgumentException(sprintf('The type `%s` is not a valid type', $reportConfiguration->getType()));
    }
}
