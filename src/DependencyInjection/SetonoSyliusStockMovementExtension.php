<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\DependencyInjection;

use Exception;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoSyliusStockMovementExtension extends AbstractResourceExtension
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
        $container->setParameter('setono_sylius_stock_movement.templates', $config['templates']);

        $loader->load('services.xml');

        $this->registerResources('setono_sylius_stock_movement', $config['driver'], $config['resources'], $container);
    }
}
