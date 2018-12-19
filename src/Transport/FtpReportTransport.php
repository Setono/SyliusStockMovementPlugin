<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Transport;

use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\ReportInterface;

final class FtpReportTransport implements ReportTransportInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function send(\SplFileInfo $file, ReportInterface $report, ReportConfigurationInterface $reportConfiguration): void
    {
        $ftp = new \Ftp();
        $ftp->connect($reportConfiguration->getFtpHost(), $reportConfiguration->getFtpPort() ?? 21);

        if (null !== $reportConfiguration->getFtpUsername()) {
            $ftp->login($reportConfiguration->getFtpUsername(), $reportConfiguration->getFtpPassword());
        }

        $ftp->put($reportConfiguration->getFtpPath() ?? '/', $file->getPathname(), FTP_BINARY);
    }

    public function supports(ReportInterface $report, ReportConfigurationInterface $reportConfiguration): bool
    {
        return null !== $reportConfiguration->getFtpHost();
    }
}
