<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Exception;

use RuntimeException;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;

final class CurrencyConversionException extends RuntimeException
{
    /** @var int */
    private $amount;

    /** @var string */
    private $sourceCurrency;

    /** @var string */
    private $targetCurrency;

    /** @var array */
    private $conversionContext;

    /**
     * @throws StringsException
     */
    public function __construct(int $amount, string $sourceCurrency, string $targetCurrency, array $conversionContext = [])
    {
        parent::__construct(sprintf('The source, %s %d, could not be converted to %s', $sourceCurrency, $amount, $targetCurrency));

        $this->amount = $amount;
        $this->sourceCurrency = $sourceCurrency;
        $this->targetCurrency = $targetCurrency;
        $this->conversionContext = $conversionContext;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getSourceCurrency(): string
    {
        return $this->sourceCurrency;
    }

    public function getTargetCurrency(): string
    {
        return $this->targetCurrency;
    }

    public function getConversionContext(): array
    {
        return $this->conversionContext;
    }
}
