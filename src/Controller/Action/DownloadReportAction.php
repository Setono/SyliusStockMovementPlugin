<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Controller\Action;

use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use Safe\Exceptions\StringsException;
use function Safe\fread;
use function Safe\sprintf;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Setono\SyliusStockMovementPlugin\Repository\ReportRepositoryInterface;
use Setono\SyliusStockMovementPlugin\Resolver\ReportPathResolverInterface;
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

    /** @var ReportPathResolverInterface */
    private $reportPathResolver;

    /** @var FilesystemInterface */
    private $filesystem;

    public function __construct(
        ReportRepositoryInterface $reportRepository,
        ReportWriterInterface $reportWriter,
        ReportPathResolverInterface $reportPathResolver,
        FilesystemInterface $filesystem
    ) {
        $this->reportRepository = $reportRepository;
        $this->reportWriter = $reportWriter;
        $this->reportPathResolver = $reportPathResolver;
        $this->filesystem = $filesystem;
    }

    /**
     * @throws StringsException
     * @throws FileNotFoundException
     */
    public function __invoke($id): StreamedResponse
    {
        /** @var ReportInterface|null $report */
        $report = $this->reportRepository->find($id);
        if (null === $report) {
            throw new NotFoundHttpException(sprintf('The report with id %s does not exist', $id));
        }

        $reportPath = $this->reportPathResolver->resolve($report);

        if (!$this->filesystem->has($reportPath)) {
            $this->reportWriter->write($report);
        }

        $stream = $this->filesystem->readStream($reportPath);
        if (false === $stream) {
            throw new \RuntimeException(sprintf('Could not open %s for reading', $reportPath));
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
