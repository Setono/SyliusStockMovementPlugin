<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Transport;

use Setono\SyliusStockMovementPlugin\Mailer\Emails;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;

final class EmailTransport implements TransportInterface
{
    /**
     * @var SenderInterface
     */
    private $sender;

    public function __construct(SenderInterface $sender)
    {
        $this->sender = $sender;
    }

    public function send(\SplFileInfo $file, ReportInterface $report, ReportConfigurationInterface $reportConfiguration): void
    {
        $this->sender->send(Emails::REPORT, $reportConfiguration->getEmailTo(), [
            'subject' => $this->resolveSubject($reportConfiguration->getEmailSubject(), $report),
            'body' => $this->resolveBody($reportConfiguration->getEmailSubject(), $report),
        ]);
    }

    public function supports(ReportInterface $report, ReportConfigurationInterface $reportConfiguration): bool
    {
        return null !== $reportConfiguration->getEmailTo() && count($reportConfiguration->getEmailTo()) > 0;
    }

    private function resolveSubject(?string $subject, ReportInterface $report): string
    {
        if (null === $subject) {
            return 'Report';
        }

        return $this->resolvePlaceholders($subject, $report);
    }

    private function resolveBody(?string $body, ReportInterface $report): string
    {
        if (null === $body) {
            return "Hi\n\nThis is a stock / stock movement report";
        }

        return $this->resolvePlaceholders($body, $report);
    }

    private function resolvePlaceholders(string $str, ReportInterface $report): string
    {
        return str_replace('%report_id%', $report->getId(), $str);
    }
}
