<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Form\DataTransformer;

use const PREG_SPLIT_NO_EMPTY;
use Safe\Exceptions\PcreException;
use Safe\Exceptions\StringsException;
use function Safe\preg_split;
use function Safe\sprintf;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

final class EmailsToArrayTransformer implements DataTransformerInterface
{
    /**
     * Transforms an array of emails into a string like 'email1@example.com,email2@example.com'
     *
     * @param  array|null $arr
     */
    public function transform($arr): string
    {
        if (null === $arr) {
            return '';
        }

        return implode(',', $arr);
    }

    /**
     * Transforms a string of emails into an array of emails
     *
     * @param string|null $emails
     *
     * @throws StringsException
     * @throws TransformationFailedException
     */
    public function reverseTransform($emails): array
    {
        if (null === $emails) {
            return [];
        }

        try {
            return preg_split('/[ ,]+/', $emails, PREG_SPLIT_NO_EMPTY);
        } catch (PcreException $e) {
            throw new TransformationFailedException(sprintf('It was not possible to convert the string "%s" to an array of emails', $emails), 0, $e);
        }
    }
}
