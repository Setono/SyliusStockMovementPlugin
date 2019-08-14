<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Validator;

use Setono\SyliusStockMovementPlugin\Factory\ErrorFactoryInterface;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ReportValidator implements ReportValidatorInterface
{
    /** @var ValidatorInterface */
    private $validator;

    /** @var ErrorFactoryInterface */
    private $errorFactory;

    /** @var array */
    private $validationGroups;

    public function __construct(ValidatorInterface $validator, ErrorFactoryInterface $errorFactory, array $validationGroups)
    {
        $this->validator = $validator;
        $this->errorFactory = $errorFactory;
        $this->validationGroups = $validationGroups;
    }

    public function validate(ReportInterface $report): void
    {
        $report->clearErrors();
        $report->setStatus(ReportInterface::STATUS_SUCCESS);

        $constraintViolationList = $this->validator->validate($report, null, $this->validationGroups);
        if ($constraintViolationList->count() > 0) {
            foreach ($constraintViolationList as $constraintViolation) {
                $error = $this->errorFactory->createFromConstraintViolation($constraintViolation);
                $report->addError($error);
            }

            $report->setStatus(ReportInterface::STATUS_ERROR);
        }
    }
}
