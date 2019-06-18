<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterFilesystemPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasParameter('setono_sylius_stock_movement.filesystem.report')) {
            return;
        }

        // todo add some check for existence of service and interface
        $container->setAlias('setono_sylius_stock_movement.storage.report', $container->getParameter('setono_sylius_stock_movement.filesystem.report'));
    }
}
