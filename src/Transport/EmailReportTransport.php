<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Transport;

use Setono\SyliusStockPlugin\Mailer\Emails;
use Setono\SyliusStockPlugin\Model\StockMovementReportConfigurationInterface;
use Setono\SyliusStockPlugin\Model\StockMovementReportInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;

final class EmailReportTransport implements ReportTransportInterface
{
    /**
     * @var SenderInterface
     */
    private $sender;

    public function __construct(SenderInterface $sender)
    {
        $this->sender = $sender;
    }

    public function send(\SplFileInfo $file, StockMovementReportInterface $report, StockMovementReportConfigurationInterface $reportConfiguration): void
    {
        $this->sender->send(Emails::REPORT, $reportConfiguration->getEmailTo(), [
            'subject' => $this->resolveSubject($reportConfiguration->getEmailSubject(), $report),
            'body' => $this->resolveBody($reportConfiguration->getEmailSubject(), $report),
        ]);
    }

    public function supports(StockMovementReportInterface $report, StockMovementReportConfigurationInterface $reportConfiguration): bool
    {
        return null !== $reportConfiguration->getEmailTo() && count($reportConfiguration->getEmailTo()) > 0;
    }

    private function resolveSubject(?string $subject, StockMovementReportInterface $report): string
    {
        if (null === $subject) {
            return 'Report';
        }

        return $this->resolvePlaceholders($subject, $report);
    }

    private function resolveBody(?string $body, StockMovementReportInterface $report): string
    {
        if (null === $body) {
            return "Hi\n\nThis is a stock / stock movement report";
        }

        return $this->resolvePlaceholders($body, $report);
    }

    private function resolvePlaceholders(string $str, StockMovementReportInterface $report): string
    {
        return str_replace('%report_id%', $report->getId(), $str);
    }
}
