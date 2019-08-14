<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Exception;

use InvalidArgumentException;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;

final class BlockNotPresentException extends InvalidArgumentException implements ExceptionInterface
{
    /** @var string */
    private $block;

    /** @var array */
    private $definedBlocks;

    /** @var string */
    private $template;

    /**
     * @throws StringsException
     */
    public function __construct(string $block, array $definedBlocks, string $template)
    {
        $this->block = $block;
        $this->definedBlocks = $definedBlocks;
        $this->template = $template;

        $message = sprintf(
            'The block "%s" is not present in the defined blocks ["%s"] of your template %s',
            $this->block,
            implode('", "', $this->definedBlocks),
            $this->template
        );

        parent::__construct($message);
    }

    public function getBlock(): string
    {
        return $this->block;
    }

    public function getDefinedBlocks(): array
    {
        return $this->definedBlocks;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }
}
