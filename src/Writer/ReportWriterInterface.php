<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Writer;

use Setono\SyliusStockMovementPlugin\Model\ReportInterface;

interface ReportWriterInterface
{
    /**
     * Will write a file based on the given report
     *
     * @return string The key of the file to be used in the filesystem
     */
    public function write(ReportInterface $report): string;
}
