<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Command;

use Setono\SyliusStockPlugin\Generator\ReportGeneratorInterface;
use Setono\SyliusStockPlugin\Provider\ReportConfigurationProviderInterface;
use Setono\SyliusStockPlugin\Writer\ReportWriterInterface;
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

    /**
     * @var ReportWriterInterface
     */
    private $reportWriter;

    public function __construct(
        ReportConfigurationProviderInterface $reportConfigurationProvider,
        ReportGeneratorInterface $reportGenerator,
        ReportWriterInterface $reportWriter
    ) {
        parent::__construct();

        $this->reportConfigurationProvider = $reportConfigurationProvider;
        $this->reportGenerator = $reportGenerator;
        $this->reportWriter = $reportWriter;
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
            $file = $this->reportWriter->write($report, $reportConfiguration);
            var_dump($file->getPathname());
        }
    }
}
