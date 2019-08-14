<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Sylius\Component\Resource\Model\TimestampableTrait;

class Report implements ReportInterface
{
    use TimestampableTrait;

    /** @var int */
    protected $id;

    /** @var string */
    protected $uuid;

    /** @var string */
    protected $status = self::STATUS_SUCCESS;

    /** @var ReportConfigurationInterface */
    protected $reportConfiguration;

    /** @var StockMovementInterface[]|Collection */
    protected $stockMovements;

    /** @var ErrorInterface[]|Collection */
    protected $errors;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
        $this->stockMovements = new ArrayCollection();
        $this->errors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @throws StringsException
     */
    public function setStatus(string $status): void
    {
        if (!in_array($status, self::getStatuses(), true)) {
            throw new InvalidArgumentException(sprintf('The status "%s" is not allowed. Allowed statuses are: ["%s"]', $status, implode('", "', self::getStatuses())));
        }
        $this->status = $status;
    }

    public function isSuccessful(): bool
    {
        return self::STATUS_SUCCESS === $this->status;
    }

    public function isErrored(): bool
    {
        return self::STATUS_ERROR === $this->status;
    }

    public static function getStatuses(): array
    {
        return [
            self::STATUS_SUCCESS => self::STATUS_SUCCESS,
            self::STATUS_ERROR => self::STATUS_ERROR,
        ];
    }

    public function getReportConfiguration(): ?ReportConfigurationInterface
    {
        return $this->reportConfiguration;
    }

    public function setReportConfiguration(ReportConfigurationInterface $reportConfiguration): void
    {
        $this->reportConfiguration = $reportConfiguration;
    }

    public function getStockMovements(): Collection
    {
        return $this->stockMovements;
    }

    public function addStockMovement(StockMovementInterface $stockMovement): void
    {
        $this->stockMovements->add($stockMovement);
    }

    public function getErrors(): Collection
    {
        return $this->errors;
    }

    public function addError(ErrorInterface $error): void
    {
        if ($this->hasError($error)) {
            return;
        }

        $this->errors->add($error);
        $error->setReport($this);
    }

    public function hasError(ErrorInterface $error): bool
    {
        return $this->errors->contains($error);
    }

    public function clearErrors(): void
    {
        foreach ($this->errors as $error) {
            $error->setReport(null);
        }

        $this->errors->clear();
    }
}
