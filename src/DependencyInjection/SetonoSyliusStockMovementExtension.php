<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\DependencyInjection;

use Exception;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoSyliusStockMovementExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $container->setParameter('setono_sylius_stock_movement.base_currency', $config['base_currency']);

        $this->registerTemplateParameter($container, $config['templates']);

        $loader->load('services.xml');

        $this->registerResources('setono_sylius_stock_movement', $config['driver'], $config['resources'], $container);
    }

    private function registerTemplateParameter(ContainerBuilder $container, array $templates): void
    {
        $res = [];

        foreach ($templates as $template => $item) {
            $res[$template] = $item['label'];
        }
        $container->setParameter('setono_sylius_stock_movement.templates', $res);
    }

    public function prepend(ContainerBuilder $container): void
    {
        if (!$container->hasExtension('framework')) {
            return;
        }

        $container->prependExtensionConfig('framework', [
            'messenger' => [
                'buses' => [
                    ['name' => 'setono_sylius_stock_movement.command_bus'],
                ],
            ],
        ]);
    }
}
