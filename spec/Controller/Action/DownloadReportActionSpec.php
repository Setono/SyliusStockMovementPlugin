<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\Controller\Action;

use League\Flysystem\FilesystemInterface;
use PhpSpec\ObjectBehavior;
use Setono\SyliusStockMovementPlugin\Controller\Action\DownloadReportAction;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Setono\SyliusStockMovementPlugin\Repository\ReportRepositoryInterface;
use Setono\SyliusStockMovementPlugin\Writer\ReportWriterInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DownloadReportActionSpec extends ObjectBehavior
{
    private const UUID = 'uuid-1234';

    private const REPORT_PATH = 'report-path';

    public function let(
        ReportRepositoryInterface $reportRepository,
        ReportWriterInterface $reportWriter,
        FilesystemInterface $filesystem
    ): void {
        $this->beConstructedWith($reportRepository, $reportWriter, $filesystem);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(DownloadReportAction::class);
    }

    public function it_throws_not_found_exception(ReportRepositoryInterface $reportRepository): void
    {
        $reportRepository->findByUuid(self::UUID)->willReturn(null);

        $this->shouldThrow(NotFoundHttpException::class)->during('__invoke', [self::UUID]);
    }

    public function it_returns_streamed_response(ReportRepositoryInterface $reportRepository, ReportInterface $report, ReportWriterInterface $reportWriter, FilesystemInterface $filesystem): void
    {
        $reportRepository->findByUuid(self::UUID)->willReturn($report);
        $reportWriter->write($report)->willReturn(self::REPORT_PATH);
        $filesystem->readStream(self::REPORT_PATH)->willReturn('resource');

        $this->__invoke(self::UUID)->shouldBeAnInstanceOf(StreamedResponse::class);
    }
}
