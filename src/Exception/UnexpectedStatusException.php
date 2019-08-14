<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Exception;

use InvalidArgumentException;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;

final class UnexpectedStatusException extends InvalidArgumentException implements ExceptionInterface
{
    /** @var string */
    private $actualStatus;

    /** @var string */
    private $expectedStatus;

    /**
     * @throws StringsException
     */
    public function __construct(string $actualStatus, string $expectedStatus)
    {
        $this->actualStatus = $actualStatus;
        $this->expectedStatus = $expectedStatus;

        $message = sprintf(
            'Unexpected status. Status was "%s". Expected status was "%s"',
            $this->actualStatus,
            $this->expectedStatus
        );

        parent::__construct($message);
    }

    public function getActualStatus(): string
    {
        return $this->actualStatus;
    }

    public function getExpectedStatus(): string
    {
        return $this->expectedStatus;
    }
}
