<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Factory;

use Setono\SyliusStockMovementPlugin\Model\ReportAwareInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationAwareInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Setono\SyliusStockMovementPlugin\Registry\TemplateRegistryInterface;
use Setono\SyliusStockMovementPlugin\Template\TemplateInterface;

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

        $template->setStockMovementReport($report);
        $template->setStockMovementReportConfiguration($reportConfiguration);

        return $template;
    }
}
