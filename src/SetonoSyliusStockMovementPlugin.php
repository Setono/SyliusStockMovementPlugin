<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin;

use Setono\SyliusStockMovementPlugin\DependencyInjection\Compiler\RegisterDataSourcesPass;
use Setono\SyliusStockMovementPlugin\DependencyInjection\Compiler\RegisterTemplatesPass;
use Setono\SyliusStockMovementPlugin\DependencyInjection\Compiler\RegisterTransportsPass;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class SetonoSyliusStockMovementPlugin extends AbstractResourceBundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterTemplatesPass());
        $container->addCompilerPass(new RegisterDataSourcesPass());
        $container->addCompilerPass(new RegisterTransportsPass());
    }

    public function getSupportedDrivers(): array
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }
}
