<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Transport;

use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\ReportInterface;

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

    public function send(\SplFileInfo $file, ReportInterface $report, ReportConfigurationInterface $reportConfiguration): void
    {
        foreach ($this->transports as $transport) {
            if (!$transport->supports($report, $reportConfiguration)) {
                continue;
            }

            $transport->send($file, $report, $reportConfiguration);
        }
    }

    public function supports(ReportInterface $report, ReportConfigurationInterface $reportConfiguration): bool
    {
        return true;
    }
}
