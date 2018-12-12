<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Factory;

use Setono\SyliusStockPlugin\Template\TemplateInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

final class TemplateFactory
{
    public function __construct(ServiceRegistryInterface $templateServiceRegistry)
    {
    }

    public function create(string $className): TemplateInterface
    {
        return new $className();
    }
}
