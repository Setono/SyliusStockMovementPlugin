<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\Filter;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Setono\SyliusStockMovementPlugin\Filter\CreatedAfterFilter;
use Setono\SyliusStockMovementPlugin\Filter\FilterInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;

class CreatedAfterFilterSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CreatedAfterFilter::class);
    }

    public function it_implements_filter_interface(): void
    {
        $this->shouldImplement(FilterInterface::class);
    }

    public function it_does_not_filter_when_date_is_null(QueryBuilder $queryBuilder, ReportConfigurationInterface $reportConfiguration): void
    {
        $this->filter($queryBuilder, $reportConfiguration, ['date' => null]);

        $queryBuilder->andWhere()->shouldNotBeCalled();
    }

    public function it_does_not_filter_when_date_is_not_an_instance_of_date_time_interface(QueryBuilder $queryBuilder, ReportConfigurationInterface $reportConfiguration): void
    {
        $this->filter($queryBuilder, $reportConfiguration, ['date' => '2020-01-01 00:00:00']);

        $queryBuilder->andWhere()->shouldNotBeCalled();
    }

    public function it_filters(QueryBuilder $queryBuilder, ReportConfigurationInterface $reportConfiguration): void
    {
        $queryBuilder->andWhere(Argument::any())->willReturn($queryBuilder);
        $queryBuilder->setParameter(Argument::type('string'), Argument::type(DateTimeInterface::class))->willReturn($queryBuilder);
        $queryBuilder->getRootAliases()->willReturn(['o']);
        $this->filter($queryBuilder, $reportConfiguration, ['date' => new DateTime()]);
    }
}
