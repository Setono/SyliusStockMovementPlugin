<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterDataSourcesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (false === $container->has('setono.sylius_stock.registry.data_source')) {
            return;
        }

        $dataSourceRegistry = $container->getDefinition('setono.sylius_stock.registry.data_source');

        $dataSourceIdentifierToLabelMap = [];
        foreach ($container->findTaggedServiceIds('setono.sylius_stock.data_source') as $id => $attributes) {
            if (!isset($attributes[0]['identifier'], $attributes[0]['label'])) {
                throw new \InvalidArgumentException('Tagged data source `' . $id . '` needs to have `identifier` and `label` attributes.');
            }

            $dataSourceIdentifierToLabelMap[$attributes[0]['identifier']] = $attributes[0]['label'];
            $dataSourceRegistry->addMethodCall('register', [$attributes[0]['identifier'], new Reference($id)]);
        }

        $container->setParameter('setono.sylius_stock.data_source_labels', $dataSourceIdentifierToLabelMap);
    }
}
