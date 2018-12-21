<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Form\DataTransformer;

use Money\Currency;
use Money\Money;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

final class MoneyToStringTransformer implements DataTransformerInterface
{
    /**
     * @param  Money|null $money
     *
     * @return string|null
     */
    public function transform($money): ?string
    {
        if(null === $money) {
            return null;
        }

        return $money->getCurrency()->getCode().' '.$money->getAmount();
    }

    /**
     * Transforms a string to a Money object
     *
     * @param  string|null $str
     *
     * @return Money|null
     *
     * @throws TransformationFailedException if format is incorrect
     */
    public function reverseTransform($str): ?Money
    {
        if (null === $str || '' === $str) {
            return null;
        }

        if(!preg_match('/^([A-Z]{3}) ([0-9]+)$/', $str, $matches)) {
            throw new TransformationFailedException('The currency format is not correct. A correct example could be USD 100 representing $1');
        }

        return new Money($matches[2], new Currency($matches[1]));
    }
}
