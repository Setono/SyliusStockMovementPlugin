<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\Message\Handler;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Setono\SyliusStockMovementPlugin\Generator\ReportGeneratorInterface;
use Setono\SyliusStockMovementPlugin\Message\Command\ProcessReportConfiguration;
use Setono\SyliusStockMovementPlugin\Message\Command\SendReport;
use Setono\SyliusStockMovementPlugin\Message\Handler\ProcessReportConfigurationHandler;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use stdClass;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class ProcessReportConfigurationHandlerSpec extends ObjectBehavior
{
    public function let(
        MessageBusInterface $commandBus,
        RepositoryInterface $reportConfigurationRepository,
        ReportGeneratorInterface $reportGenerator
    ): void {
        $this->beConstructedWith($commandBus, $reportConfigurationRepository, $reportGenerator);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ProcessReportConfigurationHandler::class);
    }

    public function it_throws_exception_when_report_configuration_is_not_found(
        RepositoryInterface $reportConfigurationRepository,
        ReportConfigurationInterface $reportConfiguration
    ): void {
        $reportConfiguration->getId()->willReturn(1);
        $reportConfigurationRepository->find(1)->willReturn(null);

        $this->shouldThrow(InvalidArgumentException::class)->during('__invoke', [new ProcessReportConfiguration(1)]);
    }

    public function it_does_not_dispatch_when_report_can_not_be_generated(
        RepositoryInterface $reportConfigurationRepository,
        MessageBusInterface $commandBus,
        ReportConfigurationInterface $reportConfiguration,
        ReportGeneratorInterface $reportGenerator
    ): void {
        $reportConfigurationRepository->find(1)->willReturn($reportConfiguration);

        $reportGenerator->generate($reportConfiguration)->willReturn(null);

        $commandBus->dispatch(Argument::any())->shouldNotBeCalled();

        $this->__invoke(new ProcessReportConfiguration(1));
    }

    public function it_dispatches(
        RepositoryInterface $reportConfigurationRepository,
        MessageBusInterface $commandBus,
        ReportConfigurationInterface $reportConfiguration,
        ReportGeneratorInterface $reportGenerator,
        ReportInterface $report
    ): void {
        $reportConfigurationRepository->find(1)->willReturn($reportConfiguration);

        $reportGenerator->generate($reportConfiguration)->willReturn($report);

        $report->getId()->willReturn(2);
        $commandBus->dispatch(new SendReport(2))->willReturn(new Envelope(new stdClass()));

        $this->__invoke(new ProcessReportConfiguration(1));
    }
}
