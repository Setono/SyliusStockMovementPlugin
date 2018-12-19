<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusStockPlugin\Application\src\Template;

use Setono\SyliusStockPlugin\Template\Template;

class TestTemplate extends Template
{
    public function getFilename(): string
    {
        return parent::getFilename().'.txt';
    }

    public function renderHeader(): string
    {
        return 'header';
    }

    public function renderFooter(): string
    {
        return 'footer';
    }

    protected function renderItem($item): string
    {
        return 'item';
    }
}
