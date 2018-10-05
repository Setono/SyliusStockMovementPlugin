<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterDeliveryMethodsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws \ReflectionException
     */
    public function process(ContainerBuilder $container): void
    {
        if (false === $container->has('setono_sylius_stock.registry.delivery_method')) {
            return;
        }

        if (false === $container->has('setono_sylius_stock.form_registry.delivery_method')) {
            return;
        }

        $deliveryMethodRegistry = $container->getDefinition('setono_sylius_stock.registry.delivery_method');
        $deliveryMethodFormTypeRegistry = $container->getDefinition('setono_sylius_stock.form_registry.delivery_method');

        $deliveryMethodTypeToLabelMap = [];
        foreach ($container->findTaggedServiceIds('setono_sylius_stock.delivery_method') as $id => $attributes) {
            $this->assertAttributes($id, $attributes);

            $type = $attributes[0]['type'];
            $this->assertType($id, $type);

            $deliveryMethodTypeToLabelMap[$type] = $attributes[0]['label'];
            $deliveryMethodRegistry->addMethodCall('register', [$type, new Reference($id)]);
            $deliveryMethodFormTypeRegistry->addMethodCall('add', [$type, 'default', $attributes[0]['form_type']]);
        }

        $container->setParameter('setono_sylius_stock.delivery_methods', $deliveryMethodTypeToLabelMap);
    }

    /**
     * @param string $id
     * @param array $attributes
     */
    private function assertAttributes(string $id, array $attributes): void
    {
        if (!isset($attributes[0]['type'], $attributes[0]['label'], $attributes[0]['form_type'])) {
            throw new \InvalidArgumentException('Tagged delivery method `' . $id . '` needs to have `type`, `form_type` and `label` attributes.');
        }
    }

    /**
     * @param string $id
     * @param string $type
     *
     * @throws \ReflectionException
     */
    private function assertType(string $id, string $type): void
    {
        $refl = new \ReflectionClass($id);
        $constants = $refl->getConstants();

        if (!array_key_exists('TYPE', $constants)) {
            throw new \InvalidArgumentException('Tagged delivery method `' . $id . '` needs to have `TYPE` constant');
        }

        if ($constants['TYPE'] !== $type) {
            throw new \InvalidArgumentException('The constant `TYPE` and the type attribute in the service definition must be equal. Constants equals `' . $constants['TYPE'] . '` and attribute equals `' . $type . '`');
        }
    }
}
