<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Factory;

use Setono\SyliusStockPlugin\Model\ReportAwareInterface;
use Setono\SyliusStockPlugin\Model\ReportConfigurationAwareInterface;
use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\ReportInterface;
use Setono\SyliusStockPlugin\Registry\TemplateRegistryInterface;
use Setono\SyliusStockPlugin\Template\TemplateInterface;

final class TemplateFactory
{
    /**
     * @var TemplateRegistryInterface
     */
    private $templateRegistry;

    public function __construct(TemplateRegistryInterface $templateRegistry)
    {
        $this->templateRegistry = $templateRegistry;
    }

    public function create(string $identifier, ReportInterface $report = null, ReportConfigurationInterface $reportConfiguration = null): TemplateInterface
    {
        $className = $this->templateRegistry->get($identifier);

        /** @var TemplateInterface $template */
        $template = new $className();

        if (null !== $report && $template instanceof ReportAwareInterface) {
            $template->setReport($report);
        }

        if (null !== $reportConfiguration && $template instanceof ReportConfigurationAwareInterface) {
            $template->setReportConfiguration($reportConfiguration);
        }

        return $template;
    }
}
