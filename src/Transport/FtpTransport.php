<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Transport;

use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Filesystem;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use SplFileInfo;

final class FtpTransport implements TransportInterface
{
    public function send(SplFileInfo $file, array $configuration, ReportInterface $report, ReportConfigurationInterface $reportConfiguration): void
    {
        $configuration['root'] = $configuration['path'] ?? null;

        $filesystem = new Filesystem(new Ftp($configuration));
        $filesystem->putStream($file->getPathname(), $file->openFile('r+'));
    }
}
