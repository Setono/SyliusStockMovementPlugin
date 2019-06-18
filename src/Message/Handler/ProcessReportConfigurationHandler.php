<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Message\Handler;

use InvalidArgumentException;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\SyliusStockMovementPlugin\Generator\ReportGeneratorInterface;
use Setono\SyliusStockMovementPlugin\Message\Command\ProcessReportConfiguration;
use Setono\SyliusStockMovementPlugin\Message\Command\SendReport;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ProcessReportConfigurationHandler implements MessageHandlerInterface
{
    /** @var MessageBusInterface */
    private $commandBus;

    /** @var RepositoryInterface */
    private $reportConfigurationRepository;

    /** @var ReportGeneratorInterface */
    private $reportGenerator;

    public function __construct(
        MessageBusInterface $commandBus,
        RepositoryInterface $reportConfigurationRepository,
        ReportGeneratorInterface $reportGenerator
    ) {
        $this->commandBus = $commandBus;
        $this->reportConfigurationRepository = $reportConfigurationRepository;
        $this->reportGenerator = $reportGenerator;
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

        $this->commandBus->dispatch(new SendReport($report));
    }
}
