<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

class Error implements ErrorInterface
{
    /** @var int */
    protected $id;

    /** @var ReportInterface|null */
    protected $report;

    /** @var string|null */
    protected $message;

    public function __toString(): string
    {
        return (string) $this->message;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReport(): ?ReportInterface
    {
        return $this->report;
    }

    public function setReport(?ReportInterface $report): void
    {
        $this->report = $report;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
