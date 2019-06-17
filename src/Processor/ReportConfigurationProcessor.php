<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Processor;

use Psr\Log\LoggerAwareTrait;
use Setono\SyliusStockMovementPlugin\Message\Command\ProcessReportConfiguration;
use Setono\SyliusStockMovementPlugin\Provider\ReportConfigurationProviderInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class ReportConfigurationProcessor implements ReportConfigurationProcessorInterface
{
    use LoggerAwareTrait;

    /** @var ReportConfigurationProviderInterface */
    private $reportConfigurationProvider;

    /** @var MessageBusInterface */
    private $commandBus;

    public function __construct(ReportConfigurationProviderInterface $reportConfigurationProvider, MessageBusInterface $commandBus)
    {
        $this->reportConfigurationProvider = $reportConfigurationProvider;
        $this->commandBus = $commandBus;
    }

    public function process(): void
    {
        $reportConfigurations = $this->reportConfigurationProvider->getReportConfigurations();

        if (count($reportConfigurations) === 0) {
            $this->logger->info('No report configurations due');
        }

        foreach ($reportConfigurations as $reportConfiguration) {
            $this->logger->info('Processing report configuration: ' . $reportConfiguration->getName());
            $this->commandBus->dispatch(new ProcessReportConfiguration($reportConfiguration->getId()));
        }
    }
}
