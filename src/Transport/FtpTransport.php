<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Transport;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;

final class FtpTransport implements TransportInterface
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
