<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Writer;

use Setono\SyliusStockPlugin\Factory\TemplateFactoryInterface;
use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\ReportInterface;
use Symfony\Component\Filesystem\Filesystem;

class ReportWriter implements ReportWriterInterface
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
    public function write(ReportInterface $report, ReportConfigurationInterface $reportConfiguration): \SplFileInfo
    {
        $template = $this->templateFactory->createWithReportAndReportConfiguration($reportConfiguration->getTemplate(), $report, $reportConfiguration);

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
