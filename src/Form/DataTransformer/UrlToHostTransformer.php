<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

final class UrlToHostTransformer implements DataTransformerInterface
{
    /**
     * @param  string|null $host
     *
     * @return string|null
     */
    public function transform($host): ?string
    {
        return $host;
    }

    /**
     * Transforms an url to it's host
     *
     * @param  string|null $url
     *
     * @return string|null
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($url): ?string
    {
        if (!$url) {
            return $url;
        }

        $host = parse_url($url, PHP_URL_HOST);
        if (null === $host || false === $host) {
            throw new TransformationFailedException(sprintf('It was not possible to extract the host from the url: "%s"', $url));
        }

        return $host;
    }
}
