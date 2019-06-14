<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\DependencyInjection\Compiler;

use InvalidArgumentException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterFiltersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('setono_sylius_stock_movement.registry.filter') || !$container->hasDefinition('setono_sylius_stock_movement.form_registry.filter')) {
            return;
        }

        $registry = $container->getDefinition('setono_sylius_stock_movement.registry.filter');
        $formTypeRegistry = $container->getDefinition('setono_sylius_stock_movement.form_registry.filter');

        $typeToLabelMap = [];
        foreach ($container->findTaggedServiceIds('setono_sylius_stock_movement.filter') as $id => $tagged) {
            foreach ($tagged as $attributes) {
                if (!isset($attributes['type'], $attributes['label'], $attributes['form_type'])) {
                    throw new InvalidArgumentException('Tagged filter `' . $id . '` needs to have `type`, `form_type` and `label` attributes.');
                }

                $typeToLabelMap[$attributes['type']] = $attributes['label'];
                $registry->addMethodCall('register', [$attributes['type'], new Reference($id)]);
                $formTypeRegistry->addMethodCall('add',
                    [$attributes['type'], 'default', $attributes['form_type']]);
            }
        }

        $container->setParameter('setono_sylius_stock_movement.filters', $typeToLabelMap);
    }
}
