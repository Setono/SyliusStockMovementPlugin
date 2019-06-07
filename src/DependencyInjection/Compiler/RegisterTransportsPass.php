<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterTransportsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('setono_sylius_stock_movement.registry.transport') || !$container->has('setono_sylius_stock_movement.form_registry.transport')) {
            return;
        }

        $transportRegistry = $container->getDefinition('setono_sylius_stock_movement.registry.transport');
        $transportFormTypeRegistry = $container->getDefinition('setono_sylius_stock_movement.form_registry.transport');

        $typeToLabelMap = [];
        foreach ($container->findTaggedServiceIds('setono_sylius_stock_movement.transport') as $id => $tagged) {
            foreach ($tagged as $attributes) {
                if (!isset($attributes['type'], $attributes['label'], $attributes['form_type'])) {
                    throw new \InvalidArgumentException('Tagged transport `' . $id . '` needs to have `type`, `form_type` and `label` attributes.');
                }

                $typeToLabelMap[$attributes['type']] = $attributes['label'];
                $transportRegistry->addMethodCall('register', [$attributes['type'], new Reference($id)]);
                $transportFormTypeRegistry->addMethodCall('add',
                    [$attributes['type'], 'default', $attributes['form_type']]);
            }
        }

        $container->setParameter('setono_sylius_stock_movement.transports', $typeToLabelMap);
    }
}
