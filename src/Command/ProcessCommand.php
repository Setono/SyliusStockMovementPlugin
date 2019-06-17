<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Command;

use Setono\SyliusStockMovementPlugin\Processor\ReportConfigurationProcessorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

final class ProcessCommand extends Command
{
    protected static $defaultName = 'setono:sylius-stock-movement:process';

    /** @var ReportConfigurationProcessorInterface */
    private $processor;

    public function __construct(ReportConfigurationProcessorInterface $processor)
    {
        parent::__construct();

        $this->processor = $processor;
    }

    protected function configure(): void
    {
        $this->setDescription('Processes report configurations');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->processor->setLogger(new ConsoleLogger($output));
        $this->processor->process();

        return 0;
    }
}
