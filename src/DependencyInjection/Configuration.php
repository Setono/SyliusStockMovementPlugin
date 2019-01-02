<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\DependencyInjection;

use Setono\SyliusStockPlugin\Form\Type\ReportConfigurationType;
use Setono\SyliusStockPlugin\Form\Type\StockMovementType;
use Setono\SyliusStockPlugin\Model\ReportConfiguration;
use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\StockMovement;
use Setono\SyliusStockPlugin\Model\StockMovementInterface;
use Setono\SyliusStockPlugin\Model\StockMovementReport;
use Setono\SyliusStockPlugin\Model\StockMovementReportInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\Form\Type\DefaultResourceType;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Component\Resource\Factory\Factory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('setono_sylius_stock');

        $rootNode
            ->addDefaultsIfNotSet()
            ->fixXmlConfig('template')
            ->children()
                ->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM)->end()
                ->scalarNode('base_currency')
                    ->info('This is the currency stock movement prices are converted into')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('templates')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('identifier')->end()
                            ->scalarNode('label')->end()
                            ->scalarNode('class')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        $this->addResourcesSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addResourcesSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('resources')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('report_configuration')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(ReportConfiguration::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(ReportConfigurationInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                        ->scalarNode('form')->defaultValue(ReportConfigurationType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('stock_movement')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(StockMovement::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(StockMovementInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                        ->scalarNode('form')->defaultValue(StockMovementType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('stock_movement_report')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(StockMovementReport::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(StockMovementReportInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                        ->scalarNode('form')->defaultValue(DefaultResourceType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
