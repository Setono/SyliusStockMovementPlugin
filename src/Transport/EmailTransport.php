<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Transport;

use Setono\SyliusStockMovementPlugin\Mailer\Emails;
use Setono\SyliusStockMovementPlugin\Model\ReportConfigurationInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Symfony\Component\Routing\RouterInterface;

final class EmailTransport implements TransportInterface
{
    /** @var SenderInterface */
    private $sender;

    /** @var RouterInterface */
    private $router;

    public function __construct(SenderInterface $sender, RouterInterface $router)
    {
        $this->sender = $sender;
        $this->router = $router;
    }

    public function send(string $file, array $configuration, ReportInterface $report, ReportConfigurationInterface $reportConfiguration): void
    {
        $this->sender->send(Emails::REPORT, $configuration['to'], [
            'subject' => $this->resolveSubject($configuration['subject'] ?? null, $report),
            'body' => $this->resolveBody($configuration['body'] ?? null, $report),
        ]);
    }

    private function resolveSubject(?string $subject, ReportInterface $report): string
    {
        if (null === $subject) {
            return 'Stock movement report ' . $report->getId();
        }

        return $this->resolvePlaceholders($subject, $report);
    }

    private function resolveBody(?string $body, ReportInterface $report): string
    {
        $reportUrl = $this->router->generate('setono_sylius_stock_movement_report_download', ['uuid' => $report->getUuid()], RouterInterface::ABSOLUTE_URL);

        if (null === $body || '' === $body) {
            return "Hi\n\nDownload the stock movement report here:\n\n$reportUrl";
        }

        if (strpos($body, '%report_url%') === false) {
            $body .= "\n\n%report_url%";
        }

        $body = str_replace('%report_url%', $reportUrl, $body);

        return $this->resolvePlaceholders($body, $report);
    }

    private function resolvePlaceholders(string $str, ReportInterface $report): string
    {
        return str_replace('%report_id%', $report->getId(), $str);
    }
}
