<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Form\DataTransformer;

use const PHP_URL_HOST;
use Safe\Exceptions\StringsException;
use Safe\Exceptions\UrlException;
use function Safe\parse_url;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

final class UrlToHostTransformer implements DataTransformerInterface
{
    /**
     * @param  string|null $host
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
     * @throws StringsException
     */
    public function reverseTransform($url): ?string
    {
        if (!$url) {
            return $url;
        }

        try {
            return parse_url($url, PHP_URL_HOST);
        } catch (UrlException $e) {
            throw new TransformationFailedException(\Safe\sprintf('It was not possible to extract the host from the url: "%s"', $url), 0, $e);
        }
    }
}
