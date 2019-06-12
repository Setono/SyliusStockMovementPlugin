<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Message\Handler;

use InvalidArgumentException;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\SyliusStockMovementPlugin\Generator\ReportGeneratorInterface;
use Setono\SyliusStockMovementPlugin\Message\Command\ProcessReportConfiguration;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Sender\ReportSenderInterface;
use Setono\SyliusStockMovementPlugin\Writer\ReportWriterInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ProcessReportConfigurationHandler implements MessageHandlerInterface
{
    /** @var RepositoryInterface */
    private $reportConfigurationRepository;

    /** @var ReportGeneratorInterface */
    private $reportGenerator;

    /** @var ReportWriterInterface */
    private $reportWriter;

    /** @var ReportSenderInterface */
    private $reportSender;

    public function __construct(
        RepositoryInterface $reportConfigurationRepository,
        ReportGeneratorInterface $reportGenerator,
        ReportWriterInterface $reportWriter,
        ReportSenderInterface $reportSender
    ) {
        $this->reportConfigurationRepository = $reportConfigurationRepository;
        $this->reportGenerator = $reportGenerator;
        $this->reportWriter = $reportWriter;
        $this->reportSender = $reportSender;
    }

    /**
     * @throws StringsException
     */
    public function __invoke(ProcessReportConfiguration $message): void
    {
        /** @var ReportConfigurationInterface|null $reportConfiguration */
        $reportConfiguration = $this->reportConfigurationRepository->find($message->getReportConfigurationId());

        if (null === $reportConfiguration) {
            throw new InvalidArgumentException(sprintf('The report configuration with id %s was not found', $message->getReportConfigurationId())); // todo better exception
        }

        $report = $this->reportGenerator->generate($reportConfiguration);

        if (null === $report) {
            return;
        }

        $file = $this->reportWriter->write($report, $reportConfiguration);

        $this->reportSender->send($file, $report, $reportConfiguration);
    }
}
