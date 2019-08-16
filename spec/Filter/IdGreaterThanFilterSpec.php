<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\Filter;

use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Setono\SyliusStockMovementPlugin\Filter\FilterInterface;
use Setono\SyliusStockMovementPlugin\Filter\IdGreaterThanFilter;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Repository\ReportRepositoryInterface;

class IdGreaterThanFilterSpec extends ObjectBehavior
{
    public function let(ReportRepositoryInterface $reportRepository): void
    {
        $this->beConstructedWith($reportRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(IdGreaterThanFilter::class);
    }

    public function it_implements_filter_interface(): void
    {
        $this->shouldImplement(FilterInterface::class);
    }

    public function it_filters_using_given_id(QueryBuilder $queryBuilder, ReportConfigurationInterface $reportConfiguration): void
    {
        $queryBuilder->andWhere(Argument::any())->willReturn($queryBuilder);
        $queryBuilder->setParameter(Argument::type('string'), 1)->willReturn($queryBuilder);
        $queryBuilder->getRootAliases()->willReturn(['o']);
        $this->filter($queryBuilder, $reportConfiguration, ['id' => 1]);
    }

    public function it_filters_using_latest_id(QueryBuilder $queryBuilder, ReportConfigurationInterface $reportConfiguration, ReportRepositoryInterface $reportRepository): void
    {
        $reportRepository->getLatestStockMovementIdOnAReport($reportConfiguration)->willReturn(101);

        $queryBuilder->andWhere(Argument::any())->willReturn($queryBuilder);
        $queryBuilder->setParameter(Argument::type('string'), 101)->willReturn($queryBuilder);
        $queryBuilder->getRootAliases()->willReturn(['o']);
        $this->filter($queryBuilder, $reportConfiguration, ['id' => null]);
    }
}
