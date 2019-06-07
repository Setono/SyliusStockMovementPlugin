<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Writer;

use Setono\SyliusStockMovementPlugin\Factory\TemplateFactoryInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Symfony\Component\Filesystem\Filesystem;

class StockMovementReportWriter implements StockMovementReportWriterInterface
{
    /**
     * @var TemplateFactoryInterface
     */
    private $templateFactory;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(TemplateFactoryInterface $templateFactory, Filesystem $filesystem)
    {
        $this->templateFactory = $templateFactory;
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function write(
        ReportInterface $stockMovementReport,
        ReportConfigurationInterface $stockMovementReportConfiguration
    ): \SplFileInfo {
        $template = $this->templateFactory->createWithReportAndReportConfiguration($stockMovementReportConfiguration->getTemplate(), $stockMovementReport, $stockMovementReportConfiguration);

        $file = $this->getTempFile();

        $file->fwrite($template->renderHeader());

        foreach ($template->renderItems() as $item) {
            $file->fwrite($item);
        }

        $file->fwrite($template->renderFooter());

        $path = $file->getPathname();

        // closes the file so it's readable/writable from another context
        $file = null;

        $newPath = sys_get_temp_dir() . '/' . $template->getFilename();

        $this->filesystem->rename($path, $newPath, true);

        return new \SplFileInfo($newPath);
    }

    private function getTempFile(): \SplFileObject
    {
        $path = $this->filesystem->tempnam(sys_get_temp_dir(), 'report-');

        return new \SplFileObject($path, 'w+');
    }
}
