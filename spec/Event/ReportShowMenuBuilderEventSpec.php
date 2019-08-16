<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\Event;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use PhpSpec\ObjectBehavior;
use Setono\SyliusStockMovementPlugin\Event\ReportShowMenuBuilderEvent;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class ReportShowMenuBuilderEventSpec extends ObjectBehavior
{
    public function let(FactoryInterface $factory, ItemInterface $menu, ReportInterface $report): void
    {
        $this->beConstructedWith($factory, $menu, $report);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ReportShowMenuBuilderEvent::class);
    }

    public function it_extends_menu_builder_event(): void
    {
        $this->shouldBeAnInstanceOf(MenuBuilderEvent::class);
    }

    public function it_returns_report(ReportInterface $report): void
    {
        $this->getReport()->shouldReturn($report);
    }
}
