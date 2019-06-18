<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Event;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class ReportShowMenuBuilderEvent extends MenuBuilderEvent
{
    /** @var ReportInterface */
    private $report;

    public function __construct(FactoryInterface $factory, ItemInterface $menu, ReportInterface $report)
    {
        parent::__construct($factory, $menu);

        $this->report = $report;
    }

    public function getReport(): ReportInterface
    {
        return $this->report;
    }
}
