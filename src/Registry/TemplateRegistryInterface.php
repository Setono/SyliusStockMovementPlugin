<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Registry;

interface TemplateRegistryInterface
{
    public function register(string $identifier, string $className): void;

    public function unregister(string $identifier): void;

    public function has(string $identifier): bool;

    public function get(string $identifier): string;

    public function all(): array;
}
