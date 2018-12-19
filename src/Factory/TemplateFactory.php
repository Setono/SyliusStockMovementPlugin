<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Factory;

use Setono\SyliusStockPlugin\Model\ReportAwareInterface;
use Setono\SyliusStockPlugin\Model\ReportConfigurationAwareInterface;
use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\ReportInterface;
use Setono\SyliusStockPlugin\Registry\TemplateRegistryInterface;
use Setono\SyliusStockPlugin\Template\TemplateInterface;

final class TemplateFactory implements TemplateFactoryInterface
{
    /**
     * @var TemplateRegistryInterface
     */
    private $templateRegistry;

    public function __construct(TemplateRegistryInterface $templateRegistry)
    {
        $this->templateRegistry = $templateRegistry;
    }

    public function create(string $identifier): TemplateInterface
    {
        $className = $this->templateRegistry->get($identifier);

        /** @var TemplateInterface $template */
        $template = new $className();

        return $template;
    }

    public function createWithReportAndReportConfiguration(
        string $identifier,
        ReportInterface $report,
        ReportConfigurationInterface $reportConfiguration
    ): TemplateInterface {
        $template = $this->create($identifier);

        if (!$template instanceof ReportAwareInterface || !$template instanceof ReportConfigurationAwareInterface) {
            throw new \RuntimeException(sprintf('The template %s does not implement one or both of the interfaces: %s, %s', \get_class($template), ReportAwareInterface::class, ReportConfigurationAwareInterface::class));
        }

        $template->setReport($report);
        $template->setReportConfiguration($reportConfiguration);

        return $template;
    }
}
