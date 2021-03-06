<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\DependencyInjection\Compiler;

use InvalidArgumentException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterTransportsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('setono_sylius_stock_movement.registry.transport') || !$container->hasDefinition('setono_sylius_stock_movement.form_registry.transport')) {
            return;
        }

        $registry = $container->getDefinition('setono_sylius_stock_movement.registry.transport');
        $formTypeRegistry = $container->getDefinition('setono_sylius_stock_movement.form_registry.transport');

        $typeToLabelMap = [];
        foreach ($container->findTaggedServiceIds('setono_sylius_stock_movement.transport') as $id => $tagged) {
            foreach ($tagged as $attributes) {
                if (!isset($attributes['type'], $attributes['label'], $attributes['form_type'])) {
                    throw new InvalidArgumentException('Tagged transport `' . $id . '` needs to have `type`, `form_type` and `label` attributes.');
                }

                $typeToLabelMap[$attributes['type']] = $attributes['label'];
                $registry->addMethodCall('register', [$attributes['type'], new Reference($id)]);
                $formTypeRegistry->addMethodCall('add',
                    [$attributes['type'], 'default', $attributes['form_type']]);
            }
        }

        $container->setParameter('setono_sylius_stock_movement.transports', $typeToLabelMap);
    }
}
