<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Factory;

use Setono\SyliusStockMovementPlugin\Model\ErrorInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

final class ErrorFactory implements ErrorFactoryInterface
{
    /** @var FactoryInterface */
    private $decoratedFactory;

    public function __construct(FactoryInterface $factory)
    {
        $this->decoratedFactory = $factory;
    }

    public function createNew(): ErrorInterface
    {
        /** @var ErrorInterface $error */
        $error = $this->decoratedFactory->createNew();

        return $error;
    }

    public function createFromConstraintViolation(ConstraintViolationInterface $constraintViolation): ErrorInterface
    {
        $error = $this->createNew();
        $error->setMessage($constraintViolation->getPropertyPath() . ': ' . $constraintViolation->getMessage());

        return $error;
    }
}
