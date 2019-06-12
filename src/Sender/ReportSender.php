<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Sender;

use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Setono\SyliusStockMovementPlugin\Transport\TransportInterface;
use SplFileInfo;
use Sylius\Component\Registry\ServiceRegistryInterface;

final class ReportSender implements ReportSenderInterface
{
    /** @var ServiceRegistryInterface */
    private $transportRegistry;

    public function __construct(ServiceRegistryInterface $transportRegistry)
    {
        $this->transportRegistry = $transportRegistry;
    }

    public function send(SplFileInfo $file, ReportInterface $report, ReportConfigurationInterface $reportConfiguration): void
    {
        foreach ($reportConfiguration->getTransports() as $reportConfigurationTransport) {
            /** @var TransportInterface $transport */
            $transport = $this->transportRegistry->get($reportConfigurationTransport->getType());

            $transport->send($file, $reportConfigurationTransport->getConfiguration(), $report, $reportConfiguration);
        }
    }
}
