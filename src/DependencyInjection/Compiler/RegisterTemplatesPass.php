<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterTemplatesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (false === $container->has('setono.sylius_stock.registry.template')) {
            return;
        }

        $templateRegistry = $container->getDefinition('setono.sylius_stock.registry.template');

        $templates = $container->getParameter('setono.sylius_stock.templates');

        foreach ($templates as $template) {
            $templateRegistry->addMethodCall('register', [$template['identifier'], $template['class']]);
        }
    }
}
