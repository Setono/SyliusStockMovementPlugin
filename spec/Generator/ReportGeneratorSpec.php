<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\Generator;

use Doctrine\Common\Collections\Collection;
use PhpSpec\ObjectBehavior;
use Setono\SyliusStockMovementPlugin\Generator\ReportGenerator;
use Setono\SyliusStockMovementPlugin\Generator\ReportGeneratorInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Setono\SyliusStockMovementPlugin\Model\StockMovementInterface;
use Setono\SyliusStockMovementPlugin\Provider\StockMovementProviderInterface;
use Setono\SyliusStockMovementPlugin\Validator\ReportValidatorInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class ReportGeneratorSpec extends ObjectBehavior
{
    public function let(
        FactoryInterface $reportFactory,
        RepositoryInterface $reportRepository,
        StockMovementProviderInterface $stockMovementProvider,
        ReportValidatorInterface $reportValidator,
        ReportInterface $report
    ): void {
        $reportFactory->createNew()->willReturn($report);

        $this->beConstructedWith($reportFactory, $reportRepository, $stockMovementProvider, $reportValidator);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ReportGenerator::class);
    }

    public function it_implements_interface(): void
    {
        $this->shouldImplement(ReportGeneratorInterface::class);
    }

    public function it_generates(
        RepositoryInterface $reportRepository,
        StockMovementProviderInterface $stockMovementProvider,
        ReportValidatorInterface $reportValidator,
        ReportInterface $report,
        ReportConfigurationInterface $reportConfiguration,
        StockMovementInterface $stockMovement,
        Collection $collection
    ): void {
        $report->setReportConfiguration($reportConfiguration)->shouldBeCalled();
        $report->getStockMovements()->willReturn($collection);
        $report->addStockMovement($stockMovement)->shouldBeCalled();
        $collection->count()->willReturn(1);

        $stockMovementProvider->getStockMovements($reportConfiguration)->willReturn([$stockMovement]);

        $reportValidator->validate($report)->shouldBeCalled();
        $reportRepository->add($report)->shouldBeCalled();

        $this->generate($reportConfiguration)->shouldReturn($report);
    }
}
