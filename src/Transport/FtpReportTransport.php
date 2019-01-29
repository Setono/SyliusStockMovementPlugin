<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Transport;

use Setono\SyliusStockPlugin\Model\StockMovementReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\StockMovementReportInterface;

final class FtpReportTransport implements ReportTransportInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function send(\SplFileInfo $file, StockMovementReportInterface $report, StockMovementReportConfigurationInterface $reportConfiguration): void
    {
        $ftp = new \Ftp();
        $ftp->connect($reportConfiguration->getFtpHost(), $reportConfiguration->getFtpPort() ?? 21);

        if (null !== $reportConfiguration->getFtpUsername()) {
            $ftp->login($reportConfiguration->getFtpUsername(), $reportConfiguration->getFtpPassword());
        }

        $ftp->put($reportConfiguration->getFtpPath() ?? '/', $file->getPathname(), FTP_BINARY);
    }

    public function supports(StockMovementReportInterface $report, StockMovementReportConfigurationInterface $reportConfiguration): bool
    {
        return null !== $reportConfiguration->getFtpHost();
    }
}
