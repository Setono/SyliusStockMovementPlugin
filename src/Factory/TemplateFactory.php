<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Factory;

use Setono\SyliusStockPlugin\Model\StockMovementReportAwareInterface;
use Setono\SyliusStockPlugin\Model\StockMovementReportConfigurationAwareInterface;
use Setono\SyliusStockPlugin\Model\StockMovementReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\StockMovementReportInterface;
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
        StockMovementReportInterface $report,
        StockMovementReportConfigurationInterface $reportConfiguration
    ): TemplateInterface {
        $template = $this->create($identifier);

        if (!$template instanceof StockMovementReportAwareInterface || !$template instanceof StockMovementReportConfigurationAwareInterface) {
            throw new \RuntimeException(sprintf('The template %s does not implement one or both of the interfaces: %s, %s', \get_class($template), StockMovementReportAwareInterface::class, StockMovementReportConfigurationAwareInterface::class));
        }

        $template->setStockMovementReport($report);
        $template->setStockMovementReportConfiguration($reportConfiguration);

        return $template;
    }
}
