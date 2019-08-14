<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface ReportInterface extends ResourceInterface, TimestampableInterface
{
    public const STATUS_SUCCESS = 'success';

    public const STATUS_ERROR = 'error';

    public function getStatus(): ?string;

    public function setStatus(string $status): void;

    /**
     * Returns true if the status equals success
     */
    public function isSuccessful(): bool;

    /**
     * Returns true if the status equals error
     */
    public function isErrored(): bool;

    /**
     * Returns an array of the available statuses
     */
    public static function getStatuses(): array;

    public function getReportConfiguration(): ?ReportConfigurationInterface;

    public function setReportConfiguration(ReportConfigurationInterface $reportConfiguration): void;

    /**
     * @return Collection|StockMovementInterface[]
     */
    public function getStockMovements(): Collection;

    public function addStockMovement(StockMovementInterface $stockMovement): void;

    /**
     * @return Collection|ErrorInterface[]
     */
    public function getErrors(): Collection;

    public function addError(ErrorInterface $error): void;

    public function hasError(ErrorInterface $error): bool;

    public function clearErrors(): void;
}
