<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Message\Handler;

use InvalidArgumentException;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\SyliusStockMovementPlugin\Message\Command\SendReport;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Setono\SyliusStockMovementPlugin\Repository\ReportRepositoryInterface;
use Setono\SyliusStockMovementPlugin\Sender\ReportSenderInterface;
use Setono\SyliusStockMovementPlugin\Writer\ReportWriterInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SendReportHandler implements MessageHandlerInterface
{
    /** @var ReportRepositoryInterface */
    private $reportRepository;

    /** @var ReportWriterInterface */
    private $reportWriter;

    /** @var ReportSenderInterface */
    private $reportSender;

    public function __construct(
        ReportRepositoryInterface $reportRepository,
        ReportWriterInterface $reportWriter,
        ReportSenderInterface $reportSender
    ) {
        $this->reportRepository = $reportRepository;
        $this->reportWriter = $reportWriter;
        $this->reportSender = $reportSender;
    }

    /**
     * @throws StringsException
     */
    public function __invoke(SendReport $message): void
    {
        /** @var ReportInterface|null $report */
        $report = $this->reportRepository->find($message->getReportId());
        if (null === $report) {
            throw new InvalidArgumentException(sprintf('The report with id %s was not found', $message->getReportId())); // todo better exception
        }

        $reportConfiguration = $report->getReportConfiguration();

        if (null === $reportConfiguration) {
            throw new InvalidArgumentException(sprintf('No report configuration associated with report %s', $report->getId())); // todo better exception
        }

        $file = $this->reportWriter->write($report);

        $this->reportSender->send($file, $report, $reportConfiguration);
    }
}
