<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

use Doctrine\Common\Collections\Collection;

interface ReportInterface
{
    public function getItems(): Collection;
}
