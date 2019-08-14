<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Controller\Action;

use Doctrine\Common\Persistence\ObjectManager;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Setono\SyliusStockMovementPlugin\Repository\ReportRepositoryInterface;
use Setono\SyliusStockMovementPlugin\Validator\ReportValidatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

final class RevalidateAction
{
    /** @var RouterInterface */
    private $router;

    /** @var FlashBagInterface */
    private $flashBag;

    /** @var ReportRepositoryInterface */
    private $reportRepository;

    /** @var ObjectManager */
    private $reportManager;

    /** @var ReportValidatorInterface */
    private $reportValidator;

    public function __construct(
        RouterInterface $router,
        FlashBagInterface $flashBag,
        ReportRepositoryInterface $reportRepository,
        ObjectManager $reportManager,
        ReportValidatorInterface $reportValidator
    ) {
        $this->router = $router;
        $this->flashBag = $flashBag;
        $this->reportRepository = $reportRepository;
        $this->reportManager = $reportManager;
        $this->reportValidator = $reportValidator;
    }

    /**
     * @throws StringsException
     */
    public function __invoke($id)
    {
        /** @var ReportInterface|null $report */
        $report = $this->reportRepository->find($id);
        if (null === $report) {
            throw new NotFoundHttpException(sprintf('The report with id %s was not found', $id));
        }

        $this->reportValidator->validate($report);
        $this->reportManager->flush();

        if ($report->isSuccessful()) {
            $this->flashBag->add('success', 'setono_sylius_stock_movement.report_is_valid');
        } else {
            $this->flashBag->add('error', 'setono_sylius_stock_movement.report_is_invalid');
        }

        return new RedirectResponse($this->router->generate('setono_sylius_stock_movement_admin_report_show', ['id' => $id]));
    }
}
