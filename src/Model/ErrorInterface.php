<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface ErrorInterface extends ResourceInterface
{
    public function __toString(): string;

    public function getReport(): ?ReportInterface;

    public function setReport(ReportInterface $report): void;

    public function getMessage(): ?string;

    public function setMessage(string $message): void;
}
