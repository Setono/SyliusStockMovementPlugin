<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Registry;

use Setono\SyliusStockMovementPlugin\Template\TemplateInterface;

class TemplateRegistry implements TemplateRegistryInterface
{
    /**
     * An array of class names
     *
     * @var string[]
     */
    private $templates = [];

    public function register(string $identifier, string $className): void
    {
        if (!is_a($className, TemplateInterface::class, true)) {
            throw new \InvalidArgumentException(sprintf('The class `%s` is not a child of %s', $className, TemplateInterface::class));
        }

        if ($this->has($identifier)) {
            throw new \InvalidArgumentException(sprintf('A template with identifier `%s` already exists', $identifier));
        }

        $this->templates[$identifier] = $className;
    }

    public function unregister(string $identifier): void
    {
        if (!$this->has($identifier)) {
            throw new \InvalidArgumentException(sprintf('The template with identifier `%s` does not exist', $identifier));
        }

        unset($this->templates[$identifier]);
    }

    public function has(string $identifier): bool
    {
        return isset($this->templates[$identifier]);
    }

    public function get(string $identifier): string
    {
        if (!$this->has($identifier)) {
            throw new \InvalidArgumentException(sprintf('The template with identifier `%s` does not exist', $identifier));
        }

        return $this->templates[$identifier];
    }

    public function all(): array
    {
        return $this->templates;
    }
}
