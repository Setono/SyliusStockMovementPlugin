<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Generator;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Setono\SyliusStockMovementPlugin\Provider\StockMovementProviderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReportGenerator implements ReportGeneratorInterface
{
    /** @var FactoryInterface */
    private $reportFactory;

    /** @var RepositoryInterface */
    private $reportRepository;

    /** @var StockMovementProviderInterface */
    private $stockMovementProvider;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(
        FactoryInterface $reportFactory,
        RepositoryInterface $reportRepository,
        StockMovementProviderInterface $stockMovementProvider,
        ValidatorInterface $validator
    ) {
        $this->reportFactory = $reportFactory;
        $this->reportRepository = $reportRepository;
        $this->stockMovementProvider = $stockMovementProvider;
        $this->validator = $validator;
    }

    public function generate(ReportConfigurationInterface $reportConfiguration): ?ReportInterface
    {
        /** @var ReportInterface $report */
        $report = $this->reportFactory->createNew();
        $report->setReportConfiguration($reportConfiguration);

        foreach ($this->stockMovementProvider->getStockMovements($reportConfiguration) as $stockMovement) {
            $report->addStockMovement($stockMovement);
        }

        if ($report->getStockMovements()->count() === 0) {
            return null;
        }

        // todo this should be improved by adding these violations to the report object so the user can see the errors
        $constraintViolationList = $this->validator->validate($report);
        if ($constraintViolationList->count() > 0) {
            return null;
        }

        $this->reportRepository->add($report);

        return $report;
    }
}
