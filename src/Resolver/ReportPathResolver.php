<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Resolver;

use InvalidArgumentException;
use RuntimeException;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Throwable;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class ReportPathResolver implements ReportPathResolverInterface
{
    /** @var Environment */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @throws StringsException
     * @throws Throwable
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function resolve(ReportInterface $report): string
    {
        $reportConfiguration = $report->getReportConfiguration();
        if (null === $reportConfiguration) {
            throw new RuntimeException(sprintf('No report configuration associated with report %s', $report->getId()));
        }

        $template = $this->twig->load($reportConfiguration->getTemplate());

        if (!$template->hasBlock('extension')) {
            throw new InvalidArgumentException(sprintf(
                'The block "extension" is not present in the template %s',
                $reportConfiguration->getTemplate()
            ));
        }

        $extension = $template->renderBlock('extension');

        return 'stock-movement-report-' . $report->getId() . '.' . $extension;
    }
}
