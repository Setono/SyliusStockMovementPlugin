<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

final class EmailsToArrayTransformer implements DataTransformerInterface
{
    /**
     * Transforms an array of emails into a string like 'email1@example.com,email2@example.com'
     *
     * @param  array|null $arr
     *
     * @return string
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
     * @param  string|null $emails
     *
     * @return array|null
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($emails): ?array
    {
        if (!$emails) {
            return null;
        }

        $arr = preg_split('/[ ,]+/', $emails, PREG_SPLIT_NO_EMPTY);
        if (false === $arr) {
            throw new TransformationFailedException(sprintf('It was not possible to convert the string "%s" to an array of emails', $emails));
        }

        return $arr;
    }
}
