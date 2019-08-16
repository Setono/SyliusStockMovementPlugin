<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusStockMovementPlugin\Behat\Context\Cli;

use Behat\Behat\Context\Context;
use League\Flysystem\FilesystemInterface;
use Setono\SyliusStockMovementPlugin\Command\ProcessCommand;
use Setono\SyliusStockMovementPlugin\Processor\ReportConfigurationProcessorInterface;
use Setono\SyliusStockMovementPlugin\Repository\ReportRepositoryInterface;
use Sylius\Bundle\CoreBundle\Command\SetupCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;

final class ProcessReportsContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    /** @var Application */
    private $application;

    /** @var CommandTester */
    private $tester;

    /** @var SetupCommand */
    private $command;

    /**
     * @var ReportConfigurationProcessorInterface
     */
    private $processor;

    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * @var ReportRepositoryInterface
     */
    private $reportRepository;

    public function __construct(
        KernelInterface $kernel,
        ReportConfigurationProcessorInterface $processor,
        FilesystemInterface $filesystem,
        ReportRepositoryInterface $reportRepository
    ) {
        $this->kernel = $kernel;
        $this->processor = $processor;
        $this->filesystem = $filesystem;
        $this->reportRepository = $reportRepository;
    }

    /**
     * @When I run the process command
     */
    public function iRunProcessCommand(): void
    {
        $this->application = new Application($this->kernel);
        $this->application->add(new ProcessCommand($this->processor));

        $this->command = $this->application->find('setono:sylius-stock-movement:process');
        $this->tester = new CommandTester($this->command);

        $this->tester->execute(['command' => 'setono:sylius-stock-movement:process']);
    }

    /**
     * @Then the command should run successfully
     */
    public function theCommandShouldRunSuccessfully(): void
    {
        Assert::same(0, $this->tester->getStatusCode());
    }

    /**
     * @Then a report file should exist with the right content
     */
    public function aReportFileShouldExistWithTheRightContent(): void
    {
        $reports = $this->reportRepository->findAll();

        Assert::count($reports, 1);

        $report = $reports[0];

        $path = 'stock-movement-report-'.$report->getId().'.csv';

        Assert::true($this->filesystem->has($path));

        $expectedContent = "Id;Date;Quantity;Variant code\n";

        foreach ($report->getStockMovements() as $stockMovement) {
            $expectedContent .= implode(';', [$stockMovement->getId(), $stockMovement->getCreatedAt()->format('F j, Y H:i'), $stockMovement->getQuantity(), $stockMovement->getVariantCode()])."\n";
        }

        Assert::same($expectedContent, $this->filesystem->read($path));
    }
}
