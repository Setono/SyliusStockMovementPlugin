<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Command;

use Setono\SyliusStockPlugin\Generator\StockMovementReportGeneratorInterface;
use Setono\SyliusStockPlugin\Provider\StockMovementReportConfigurationProviderInterface;
use Setono\SyliusStockPlugin\Transport\ReportTransportInterface;
use Setono\SyliusStockPlugin\Writer\StockMovementReportWriterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateCommand extends Command
{
    protected static $defaultName = 'setono:sylius_stock:generate';

    /**
     * @var StockMovementReportConfigurationProviderInterface
     */
    private $stockMovementReportConfigurationProvider;

    /**
     * @var StockMovementReportGeneratorInterface
     */
    private $stockMovementReportGenerator;

    /**
     * @var StockMovementReportWriterInterface
     */
    private $reportWriter;

    /**
     * @var ReportTransportInterface
     */
    private $reportTransport;

    public function __construct(
        StockMovementReportConfigurationProviderInterface $stockMovementReportConfigurationProvider,
        StockMovementReportGeneratorInterface $stockMovementReportGenerator,
        StockMovementReportWriterInterface $reportWriter,
        ReportTransportInterface $reportTransport
    ) {
        parent::__construct();

        $this->stockMovementReportConfigurationProvider = $stockMovementReportConfigurationProvider;
        $this->stockMovementReportGenerator = $stockMovementReportGenerator;
        $this->reportWriter = $reportWriter;
        $this->reportTransport = $reportTransport;
    }

    protected function configure(): void
    {
        $this->setDescription('Generates reports');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $reportConfigurations = $this->stockMovementReportConfigurationProvider->getStockMovementReportConfigurations();

        foreach ($reportConfigurations as $reportConfiguration) {
            $report = $this->stockMovementReportGenerator->generate($reportConfiguration);
            if (null === $report) {
                continue;
            }

            $file = $this->reportWriter->write($report, $reportConfiguration);
            var_dump($file->getPathname());

            if ($this->reportTransport->supports($report, $reportConfiguration)) {
                $this->reportTransport->send($file, $report, $reportConfiguration);
            }
        }
    }
}
