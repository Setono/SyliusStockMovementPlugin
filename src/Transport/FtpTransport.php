<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Transport;

use Exception;
use Ftp;
use const FTP_BINARY;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use SplFileInfo;

final class FtpTransport implements TransportInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function send(SplFileInfo $file, array $configuration, ReportInterface $report, ReportConfigurationInterface $reportConfiguration): void
    {
        $ftp = new Ftp();
        $ftp->connect($configuration['host'], $configuration['port'] ?? 21);

        if (null !== $configuration['username'] && null !== $configuration['password']) {
            $ftp->login($configuration['username'], $configuration['password']);
        }

        $ftp->put($configuration['path'] ?? '/', $file->getPathname(), FTP_BINARY);
    }
}
