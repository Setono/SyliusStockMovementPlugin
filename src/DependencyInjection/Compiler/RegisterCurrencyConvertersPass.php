<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterCurrencyConvertersPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('setono_sylius_stock_movement.currency_converter.composite')) {
            return;
        }

        $compositeCurrencyConverter = $container->getDefinition('setono_sylius_stock_movement.currency_converter.composite');

        $currencyConverters = $this->findAndSortTaggedServices('setono_sylius_stock_movement.currency_converter', $container);

        foreach ($currencyConverters as $currencyConverter) {
            $compositeCurrencyConverter->addArgument($currencyConverter);
        }
    }
}
