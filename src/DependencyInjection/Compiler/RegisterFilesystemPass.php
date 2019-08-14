<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\DependencyInjection\Compiler;

use League\Flysystem\FilesystemInterface;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Symfony\Component\Config\Definition\Exception\InvalidDefinitionException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterFilesystemPass implements CompilerPassInterface
{
    private const PARAMETER = 'setono_sylius_stock_movement.filesystem.report';

    /**
     * @throws StringsException
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasParameter(self::PARAMETER)) {
            return;
        }

        $parameterValue = $container->getParameter(self::PARAMETER);
        if (!$container->hasDefinition($parameterValue)) {
            return;
        }

        $definition = $container->getDefinition($parameterValue);
        if (!is_a($definition->getClass(), FilesystemInterface::class, true)) {
            throw new InvalidDefinitionException(sprintf(
                'The config parameter "%s" references a service %s, which is not an instance of %s. Fix this by creating a valid service that implements %s.',
                self::PARAMETER,
                $definition->getClass(),
                FilesystemInterface::class,
                FilesystemInterface::class
            ));
        }

        $container->setAlias('setono_sylius_stock_movement.storage.report', $parameterValue);
    }
}
