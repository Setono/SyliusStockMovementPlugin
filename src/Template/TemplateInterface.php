<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Template;

interface TemplateInterface
{
    /**
     * @return string
     */
    public function getFilename(): string;

    /**
     * @return string
     */
    public function renderHeader(): string;

    /**
     * @return string
     */
    public function renderFooter(): string;

    /**
     * Will return a rendered item for each iteration
     *
     * @return \Generator
     */
    public function renderItems(): \Generator;
}
