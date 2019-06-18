<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Writer;

use InvalidArgumentException;
use League\Flysystem\FilesystemInterface;
use Safe\Exceptions\FilesystemException;
use Safe\Exceptions\OutcontrolException;
use Safe\Exceptions\StringsException;
use function Safe\fopen;
use function Safe\fwrite;
use function Safe\ob_end_clean;
use function Safe\sprintf;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Setono\SyliusStockMovementPlugin\Resolver\ReportPathResolverInterface;
use Throwable;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ReportWriter implements ReportWriterInterface
{
    /** @var Environment */
    private $twig;

    /** @var FilesystemInterface */
    private $filesystem;

    /** @var ReportPathResolverInterface */
    private $reportPathResolver;

    public function __construct(Environment $twig, FilesystemInterface $filesystem, ReportPathResolverInterface $reportPathResolver)
    {
        $this->filesystem = $filesystem;
        $this->twig = $twig;
        $this->reportPathResolver = $reportPathResolver;
    }

    /**
     * @throws FilesystemException
     * @throws OutcontrolException
     * @throws StringsException
     * @throws Throwable
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function write(ReportInterface $report): string
    {
        $key = $this->reportPathResolver->resolve($report);
        // todo should we provide some kind of 'overwrite' parameter?
        if ($this->filesystem->has($key)) {
            return $key;
        }

        $reportConfiguration = $report->getReportConfiguration();
        if (null === $reportConfiguration) {
            throw new \RuntimeException(sprintf('No report configuration associated with report %s', $report->getId()));
        }

        $template = $this->twig->load($reportConfiguration->getTemplate());

        $definedBlocks = $template->getBlockNames();
        foreach (['extension', 'body'] as $block) {
            if (!in_array($block, $definedBlocks, true)) {
                throw new InvalidArgumentException(sprintf(
                    'The block "%s" is not present in the defined blocks ["%s"] of your template %s',
                    $block,
                    implode('", "', $definedBlocks),
                    $reportConfiguration->getTemplate()
                )); // todo better exception
            }
        }

        $path = $this->generateTempPath();

        $fp = fopen($path, 'w+b'); // needs to be w+ since we use the same stream later to read from

        ob_start(static function ($buffer) use ($fp) {
            fwrite($fp, $buffer);
        }, 1024);

        $template->displayBlock('body', [
            'stockMovements' => $report->getStockMovements(),
        ]);

        ob_end_clean();

        $this->filesystem->writeStream($key, $fp); // todo throw exception if it returns false

        return $key;
    }

    private function generateTempPath(): string
    {
        do {
            $path = sys_get_temp_dir() . '/' . uniqid('stock-movement-report-', true);
        } while (file_exists($path));

        return $path;
    }
}
