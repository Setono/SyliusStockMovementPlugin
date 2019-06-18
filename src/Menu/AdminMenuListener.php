<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $stockHeader = $this->getHeader($menu);

        $stockHeader
            ->addChild('stock_movement_report_configurations', [
                'route' => 'setono_sylius_stock_movement_admin_report_configuration_index',
            ])
            ->setLabel('setono_sylius_stock_movement.menu.admin.main.stock.report_configurations')
            ->setLabelAttribute('icon', 'cog')
        ;

        $stockHeader
            ->addChild('stock_movement_reports', [
                'route' => 'setono_sylius_stock_movement_admin_report_index',
            ])
            ->setLabel('setono_sylius_stock_movement.menu.admin.main.stock.reports')
            ->setLabelAttribute('icon', 'chart bar')
        ;

        $stockHeader
            ->addChild('stock_movements', [
                'route' => 'setono_sylius_stock_movement_admin_stock_movement_index',
            ])
            ->setLabel('setono_sylius_stock_movement.menu.admin.main.stock.stock_movements')
            ->setLabelAttribute('icon', 'chart bar')
        ;
    }

    /**
     * This ensures that use the existing stock header if it exists
     * else we will create it
     */
    private function getHeader(ItemInterface $menu): ItemInterface
    {
        $header = $menu->getChild('stock');

        if (null === $header) {
            $header = $menu->addChild('stock')
                ->setLabel('setono_sylius_stock_movement.menu.admin.main.stock.header')
                ->setLabelAttribute('icon', 'building')
            ;
        }

        return $header;
    }
}
