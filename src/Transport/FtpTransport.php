<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Transport;

use League\Flysystem\Adapter\Ftp;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
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

    /**
     * @throws FileNotFoundException
     * @throws StringsException
     */
    public function send(string $file, array $configuration, ReportInterface $report, ReportConfigurationInterface $reportConfiguration): void
    {
        $configuration['root'] = $configuration['path'] ?? null;

        $stream = $this->filesystem->readStream($file);
        if (false === $stream) {
            throw new \RuntimeException(sprintf('The stream for the file %s could not be created', $file));
        }

        $filesystem = new Filesystem(new Ftp($configuration));
        $filesystem->putStream($file, $stream);
    }
}
