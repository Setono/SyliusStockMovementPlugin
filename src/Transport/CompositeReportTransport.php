<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Transport;

use Setono\SyliusStockPlugin\Model\StockMovementReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\StockMovementReportInterface;

final class CompositeReportTransport implements ReportTransportInterface
{
    /**
     * @var ReportTransportInterface[]
     */
    private $transports;

    public function __construct(ReportTransportInterface ...$transports)
    {
        $this->transports = $transports;
    }

    public function send(\SplFileInfo $file, StockMovementReportInterface $report, StockMovementReportConfigurationInterface $reportConfiguration): void
    {
        foreach ($this->transports as $transport) {
            if (!$transport->supports($report, $reportConfiguration)) {
                continue;
            }

            $transport->send($file, $report, $reportConfiguration);
        }
    }

    public function supports(StockMovementReportInterface $report, StockMovementReportConfigurationInterface $reportConfiguration): bool
    {
        return true;
    }
}
