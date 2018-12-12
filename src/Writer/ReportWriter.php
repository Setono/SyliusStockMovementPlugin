<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Writer;

use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\ReportInterface;
use Setono\SyliusStockPlugin\Template\TemplateInterface;

class ReportWriter implements ReportWriterInterface
{
    /**
     * {@inheritdoc}
     */
    public function write(ReportInterface $report, ReportConfigurationInterface $reportConfiguration): \SplFileInfo
    {
        // todo
        /** @var TemplateInterface $template */
        $template = null;

        $file = $this->getTempFile();

        $file->fwrite($template->renderHeader());

        foreach ($template->renderItems() as $item) {
            $file->fwrite($item);
        }

        $file->fwrite($template->renderFooter());

        $info = $file->getFileInfo();

        // closes the file so it's readable/writable from another context
        $file = null;

        return $info;
    }

    private function getTempFile(): \SplFileObject
    {
        do {
            $fileInfo = new \SplFileInfo(uniqid('report-', true));
        } while ($fileInfo->isFile());

        return $fileInfo->openFile('w+');
    }
}
