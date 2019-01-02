<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $stockHeader = $menu->addChild('stock')
            ->setLabel('setono_sylius_stock.menu.admin.main.stock.header')
            ->setLabelAttribute('icon', 'building')
        ;

        $stockHeader
            ->addChild('report_configurations', [
                'route' => 'setono_sylius_stock_admin_report_configuration_index',
            ])
            ->setLabel('setono_sylius_stock.menu.admin.main.stock.report_configurations')
            ->setLabelAttribute('icon', 'chart bar')
        ;

        $stockHeader
            ->addChild('stock_movement_reports', [
                'route' => 'setono_sylius_stock_admin_stock_movement_report_index',
            ])
            ->setLabel('setono_sylius_stock.menu.admin.main.stock.stock_movement_reports')
            ->setLabelAttribute('icon', 'chart bar')
        ;
    }
}
