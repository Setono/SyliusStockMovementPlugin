<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Writer;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use SplFileInfo;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;

class ReportWriter implements ReportWriterInterface
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Environment $twig, Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->twig = $twig;
    }

    public function write(ReportInterface $report, ReportConfigurationInterface $reportConfiguration): SplFileInfo
    {
        // todo verify that all required blocks are available

        $template = $this->twig->load($reportConfiguration->getTemplate());

        $definedBlocks = $template->getBlockNames();
        foreach (['extension', 'body'] as $block) {
            if (!in_array($block, $definedBlocks, true)) {
                throw new \InvalidArgumentException(sprintf(
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

        echo $path . "\n";

        return new SplFileInfo($path);
    }
}
