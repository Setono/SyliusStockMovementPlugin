<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Generator;

use Generator;
use Setono\SyliusStockPlugin\DataSource\DataSourceInterface;
use Setono\SyliusStockPlugin\Model\StockMovementReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\StockMovementReportInterface;
use Setono\SyliusStockPlugin\Provider\LatestIdProviderInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class StockMovementReportGenerator implements StockMovementReportGeneratorInterface
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

    /**
     * @var LatestIdProviderInterface
     */
    private $latestIdProvider;

    public function __construct(
        FactoryInterface $stockMovementReportFactory,
        RepositoryInterface $stockMovementReportRepository,
        ServiceRegistryInterface $dataSourceRegistry,
        LatestIdProviderInterface $latestIdProvider
    ) {
        $this->stockMovementReportFactory = $stockMovementReportFactory;
        $this->stockMovementReportRepository = $stockMovementReportRepository;
        $this->dataSourceRegistry = $dataSourceRegistry;
        $this->latestIdProvider = $latestIdProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(StockMovementReportConfigurationInterface $stockMovementReportConfiguration): ?StockMovementReportInterface
    {
        /** @var DataSourceInterface $dataSource */
        $dataSource = $this->dataSourceRegistry->get($stockMovementReportConfiguration->getDataSource());
        $dataSource->guardAgainstLatestId($this->latestIdProvider->getLatestId($stockMovementReportConfiguration));

        /** @var StockMovementReportInterface $report */
        $report = $this->stockMovementReportFactory->createNew();
        $report->setReportConfiguration($stockMovementReportConfiguration);

        $hasStockMovements = false;

        foreach ($this->getStockMovements($dataSource) as $stockMovement) {
            $report->addStockMovement($stockMovement);

            $hasStockMovements = true;
        }

        if (!$hasStockMovements) {
            return null;
        }

        $this->stockMovementReportRepository->add($report);

        return $report;
    }

    private function getStockMovements(DataSourceInterface $dataSource): Generator
    {
        $pager = $dataSource->getData();
        $pager->setMaxPerPage(100);
        $pages = $pager->getNbPages();

        for ($page = 1; $page <= $pages; ++$page) {
            $pager->setCurrentPage($page);

            yield from $pager->getCurrentPageResults();
        }
    }
}
