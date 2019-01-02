<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Generator;

use Setono\SyliusStockPlugin\DataSource\DataSourceInterface;
use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\ReportInterface;
use Setono\SyliusStockPlugin\Model\StockMovement;
use Setono\SyliusStockPlugin\Model\StockMovementReportInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;
use Generator;

class StockMovementReportGenerator implements ReportGeneratorInterface
{
    /**
     * @var FactoryInterface
     */
    private $stockMovementReportFactory;

    /**
     * @var RepositoryInterface
     */
    private $stockMovementReportRepository;

    /**
     * @var ServiceRegistryInterface
     */
    private $dataSourceRegistry;

    public function __construct(FactoryInterface $stockMovementReportFactory, RepositoryInterface $stockMovementReportRepository, ServiceRegistryInterface $dataSourceRegistry)
    {
        $this->stockMovementReportFactory = $stockMovementReportFactory;
        $this->stockMovementReportRepository = $stockMovementReportRepository;
        $this->dataSourceRegistry = $dataSourceRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(ReportConfigurationInterface $reportConfiguration): ReportInterface
    {
        Assert::eq($reportConfiguration->getType(), ReportConfigurationInterface::TYPE_STOCK_MOVEMENT);

        /** @var DataSourceInterface $dataSource */
        $dataSource = $this->dataSourceRegistry->get($reportConfiguration->getDataSource());

        /** @var StockMovementReportInterface $report */
        $report = $this->stockMovementReportFactory->createNew();
        $report->setReportConfiguration($reportConfiguration);

        foreach ($this->getStockMovements($dataSource) as $stockMovement) {
            $report->addStockMovement($stockMovement);
        }

        $this->stockMovementReportRepository->add($report);

        return $report;
    }

    private function getStockMovements(DataSourceInterface $dataSource): Generator
    {

        $pager = $dataSource->getData();
        $pager->setMaxPerPage(100);
        $pages = $pager->getNbPages();

        for($page = 1; $page <= $pages; $page++) {
            $pager->setCurrentPage($page);

            yield from $pager->getCurrentPageResults();
        }
    }
}
