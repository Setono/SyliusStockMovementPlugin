<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Writer;

use InvalidArgumentException;
use Safe\Exceptions\FilesystemException;
use Safe\Exceptions\OutcontrolException;
use Safe\Exceptions\StringsException;
use function Safe\fclose;
use function Safe\fopen;
use function Safe\fwrite;
use function Safe\ob_end_clean;
use function Safe\sprintf;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use SplFileInfo;
use Symfony\Component\Filesystem\Filesystem;
use Throwable;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ReportWriter implements ReportWriterInterface
{
    /** @var Environment */
    private $twig;

    /** @var Filesystem */
    private $filesystem;

    public function __construct(Environment $twig, Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->twig = $twig;
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
    public function write(ReportInterface $report, ReportConfigurationInterface $reportConfiguration): SplFileInfo
    {
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

        $extension = $template->renderBlock('extension');
        $path = $this->filesystem->tempnam(sys_get_temp_dir(), 'stock-movement-report-') . '.' . $extension;

        $fp = fopen($path, 'wb');

        ob_start(static function ($buffer) use ($fp) {
            fwrite($fp, $buffer);
        }, 1024);

        $template->displayBlock('body', [
            'stockMovements' => $report->getStockMovements(),
        ]);

        ob_end_clean();

        fclose($fp);

        return new SplFileInfo($path);
    }
}
