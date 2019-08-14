<?php

namespace spec\Setono\SyliusStockMovementPlugin\Provider;

use Cron\CronExpression;
use PhpSpec\ObjectBehavior;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Provider\DueReportConfigurationProvider;
use Setono\SyliusStockMovementPlugin\Provider\ReportConfigurationProviderInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class DueReportConfigurationProviderSpec extends ObjectBehavior
{
    public function let(RepositoryInterface $reportConfigurationRepository): void
    {
        $this->beConstructedWith($reportConfigurationRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(DueReportConfigurationProvider::class);
    }

    public function it_implements_report_configuration_provider_interface(): void
    {
        $this->shouldImplement(ReportConfigurationProviderInterface::class);
    }

    public function it_returns_no_report_configurations_when_schedule_is_null(
        RepositoryInterface $reportConfigurationRepository,
        ReportConfigurationInterface $reportConfiguration1
    ): void {
        $reportConfiguration1->getSchedule()->willReturn(null);

        $reportConfigurationRepository->findAll()->willReturn([$reportConfiguration1]);

        $this->getReportConfigurations()->shouldReturn([]);
    }

    public function it_returns_due_report_configurations(
        RepositoryInterface $reportConfigurationRepository,
        ReportConfigurationInterface $reportConfiguration1,
        ReportConfigurationInterface $reportConfiguration2,
        ReportConfigurationInterface $reportConfiguration3,
        CronExpression $cronExpression1,
        CronExpression $cronExpression2,
        CronExpression $cronExpression3
    ): void {
        $cronExpression2->isDue()->willReturn(true);

        $reportConfiguration1->getSchedule()->willReturn($cronExpression1);
        $reportConfiguration2->getSchedule()->willReturn($cronExpression2);
        $reportConfiguration3->getSchedule()->willReturn($cronExpression3);

        $reportConfigurationRepository->findAll()->willReturn([$reportConfiguration1, $reportConfiguration2, $reportConfiguration3]);

        $this->getReportConfigurations()->shouldReturn([1 => $reportConfiguration2]); // array keys are preserved when using array_filter
    }
}
