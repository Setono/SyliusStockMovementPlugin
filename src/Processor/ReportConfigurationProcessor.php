<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Processor;

use Setono\SyliusStockMovementPlugin\Message\Command\ProcessReportConfiguration;
use Setono\SyliusStockMovementPlugin\Provider\ReportConfigurationProviderInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class ReportConfigurationProcessor implements ReportConfigurationProcessorInterface
{
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

        foreach ($reportConfigurations as $reportConfiguration) {
            $this->commandBus->dispatch(new ProcessReportConfiguration($reportConfiguration->getId()));
        }
    }
}
