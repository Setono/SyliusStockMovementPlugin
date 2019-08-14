<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Factory;

use Setono\SyliusStockMovementPlugin\Model\ErrorInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

interface ErrorFactoryInterface extends FactoryInterface
{
    public function createFromConstraintViolation(ConstraintViolationInterface $constraintViolation): ErrorInterface;
}
