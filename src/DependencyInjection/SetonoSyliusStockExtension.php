<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoSyliusStockExtension extends AbstractResourceExtension
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $container->setParameter('setono.sylius_stock.base_currency', $config['base_currency']);
        $container->setParameter('setono.sylius_stock.templates', $config['templates']);

        $loader->load('services.xml');

        $this->registerResources('setono_sylius_stock', $config['driver'], $config['resources'], $container);
    }
}
