<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Transport;

use Setono\SyliusStockMovementPlugin\Mailer\Emails;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use SplFileInfo;
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

    public function send(SplFileInfo $file, array $configuration, ReportInterface $report, ReportConfigurationInterface $reportConfiguration): void
    {
        $this->sender->send(Emails::REPORT, $configuration['to'], [
            'subject' => $this->resolveSubject($configuration['subject'] ?? null, $report),
            'body' => $this->resolveBody($configuration['body'] ?? null, $report),
        ]);
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
            return "Hi\n\nThis is a stock movement report";
        }

        return $this->resolvePlaceholders($body, $report);
    }

    private function resolvePlaceholders(string $str, ReportInterface $report): string
    {
        return str_replace('%report_id%', $report->getId(), $str);
    }
}
