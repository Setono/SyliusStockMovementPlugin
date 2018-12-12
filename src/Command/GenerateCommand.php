<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Command;

use Setono\SyliusStockPlugin\Generator\ReportGeneratorInterface;
use Setono\SyliusStockPlugin\Provider\ReportConfigurationProviderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateCommand extends Command
{
    protected static $defaultName = 'setono:sylius_stock:generate';

    /**
     * @var ReportConfigurationProviderInterface
     */
    private $reportConfigurationProvider;

    /**
     * @var ReportGeneratorInterface
     */
    private $reportGenerator;

    public function __construct(
        ReportConfigurationProviderInterface $reportConfigurationProvider,
        ReportGeneratorInterface $reportGenerator
    ) {
        parent::__construct();

        $this->reportConfigurationProvider = $reportConfigurationProvider;
        $this->reportGenerator = $reportGenerator;
    }

    protected function configure(): void
    {
        $this->setDescription('Generates reports');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $reportConfigurations = $this->reportConfigurationProvider->getReportConfigurations();

        foreach ($reportConfigurations as $reportConfiguration) {
            $report = $this->reportGenerator->generate($reportConfiguration);
        }
    }
}
