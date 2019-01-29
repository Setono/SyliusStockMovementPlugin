<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $stockHeader = $this->getHeader($menu);

        $stockHeader
            ->addChild('stock_movement_report_configurations', [
                'route' => 'setono_sylius_stock_admin_stock_movement_report_configuration_index',
            ])
            ->setLabel('setono_sylius_stock.menu.admin.main.stock.stock_movement_report_configurations')
            ->setLabelAttribute('icon', 'cog')
        ;

        $stockHeader
            ->addChild('stock_movement_reports', [
                'route' => 'setono_sylius_stock_admin_stock_movement_report_index',
            ])
            ->setLabel('setono_sylius_stock.menu.admin.main.stock.stock_movement_reports')
            ->setLabelAttribute('icon', 'chart bar')
        ;
    }

    /**
     * This ensures that use the existing stock header if it exists
     * else we will create it
     *
     * @param ItemInterface $menu
     *
     * @return ItemInterface
     */
    private function getHeader(ItemInterface $menu): ItemInterface
    {
        $header = $menu->getChild('stock');

        if (null === $header) {
            $header = $menu->addChild('stock')
                ->setLabel('setono_sylius_stock.menu.admin.main.stock.header')
                ->setLabelAttribute('icon', 'building')
            ;
        }

        return $header;
    }
}
