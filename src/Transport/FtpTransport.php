<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Transport;

use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;

final class FtpTransport implements TransportInterface
{
    /** @var FilesystemInterface */
    private $filesystem;

    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function send(string $file, array $configuration, ReportInterface $report, ReportConfigurationInterface $reportConfiguration): void
    {
        $configuration['root'] = $configuration['path'] ?? null;

        $filesystem = new Filesystem(new Ftp($configuration));
        $filesystem->putStream($file, $this->filesystem->readStream($file));
    }
}
