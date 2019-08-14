<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Controller\Action;

use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use RuntimeException;
use Safe\Exceptions\StringsException;
use function Safe\fread;
use function Safe\sprintf;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Setono\SyliusStockMovementPlugin\Repository\ReportRepositoryInterface;
use Setono\SyliusStockMovementPlugin\Writer\ReportWriterInterface;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class DownloadReportAction
{
    /** @var ReportRepositoryInterface */
    private $reportRepository;

    /** @var ReportWriterInterface */
    private $reportWriter;

    /** @var FilesystemInterface */
    private $filesystem;

    public function __construct(
        ReportRepositoryInterface $reportRepository,
        ReportWriterInterface $reportWriter,
        FilesystemInterface $filesystem
    ) {
        $this->reportRepository = $reportRepository;
        $this->reportWriter = $reportWriter;
        $this->filesystem = $filesystem;
    }

    /**
     * @throws StringsException
     * @throws FileNotFoundException
     */
    public function __invoke(string $uuid): StreamedResponse
    {
        /** @var ReportInterface|null $report */
        $report = $this->reportRepository->findByUuid($uuid);
        if (null === $report) {
            throw new NotFoundHttpException(sprintf('The report with uuid %s does not exist', $uuid));
        }

        $reportPath = $this->reportWriter->write($report);

        $stream = $this->filesystem->readStream($reportPath);
        if (false === $stream) {
            throw new RuntimeException(sprintf('Could not open %s for reading', $reportPath));
        }

        $response = new StreamedResponse();
        $response->setCallback(static function () use ($stream) {
            while (!feof($stream)) {
                echo fread($stream, 8192);
                flush();
            }
        });

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            basename($reportPath)
        );
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
