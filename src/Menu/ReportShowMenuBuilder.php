<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Setono\SyliusStockMovementPlugin\Event\ReportShowMenuBuilderEvent;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;

final class ReportShowMenuBuilder
{
    /** @var FactoryInterface */
    private $factory;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(FactoryInterface $factory, EventDispatcherInterface $eventDispatcher)
    {
        $this->factory = $factory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function createMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        if (!isset($options['report'])) {
            return $menu;
        }

        $report = $options['report'];

        if (!$report instanceof ReportInterface) {
            return $menu;
        }

        if ($report->isSuccessful()) {
            $menu
                ->addChild('send_report', [
                    'route' => 'setono_sylius_stock_movement_admin_report_send',
                    'routeParameters' => ['id' => $report->getId()],
                ])
                ->setAttribute('type', 'link')
                ->setLabel('setono_sylius_stock_movement.ui.send_report')
                ->setLabelAttribute('icon', 'paper plane');
        } else {
            $menu
                ->addChild('revalidate', [
                    'route' => 'setono_sylius_stock_movement_admin_report_revalidate',
                    'routeParameters' => ['id' => $report->getId()],
                ])
                ->setAttribute('type', 'link')
                ->setLabel('setono_sylius_stock_movement.ui.revalidate')
                ->setLabelAttribute('icon', 'redo');
        }

        $menu
            ->addChild('download_report', [
                'route' => 'setono_sylius_stock_movement_report_download',
                'routeParameters' => ['uuid' => $report->getUuid()],
            ])
            ->setAttribute('type', 'link')
            ->setLabel('setono_sylius_stock_movement.ui.download_report')
            ->setLabelAttribute('icon', 'cloud download')
            ->setLabelAttribute('color', 'yellow')
        ;

        $this->eventDispatcher->dispatch(new ReportShowMenuBuilderEvent($this->factory, $menu, $report));

        return $menu;
    }
}
