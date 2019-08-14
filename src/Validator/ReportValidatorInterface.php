<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Validator;

use Setono\SyliusStockMovementPlugin\Model\ReportInterface;

interface ReportValidatorInterface
{
    public function validate(ReportInterface $report): void;
}
