<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusStockMovementPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Cron\CronExpression;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class ReportConfigurationContext implements Context
{
    /**
     * @var FactoryInterface
     */
    private $reportConfigurationFactory;

    /**
     * @var RepositoryInterface
     */
    private $reportConfigurationRepository;

    public function __construct(FactoryInterface $reportConfigurationFactory, RepositoryInterface $reportConfigurationRepository)
    {
        $this->reportConfigurationFactory = $reportConfigurationFactory;
        $this->reportConfigurationRepository = $reportConfigurationRepository;
    }

    /**
     * @Given a report configuration is due
     */
    public function aReportConfigurationIsDue(): void
    {
        /** @var ReportConfigurationInterface $reportConfiguration */
        $reportConfiguration = $this->reportConfigurationFactory->createNew();

        $reportConfiguration->setName('Report configuration #1');
        $reportConfiguration->setSchedule(CronExpression::factory('* * * * *'));
        $reportConfiguration->setTemplate('@SetonoSyliusStockMovementPlugin/Template/default.txt.twig');

        $this->reportConfigurationRepository->add($reportConfiguration);
    }
}
