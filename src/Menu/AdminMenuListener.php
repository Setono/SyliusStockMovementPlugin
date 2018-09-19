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
        $menu->addChild('stock')
            ->setLabel('setono_sylius_stock.menu.admin.main.stock.header')
            ->setLabelAttribute('icon', 'building')
                ->addChild('report_configurations', [
                    'route' => 'setono_sylius_stock_admin_report_configuration_index',
                ])
                ->setLabel('setono_sylius_stock.menu.admin.main.stock.report_configurations')
                ->setLabelAttribute('icon', 'chart bar')
        ;
    }
}
