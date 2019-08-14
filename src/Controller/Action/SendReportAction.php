<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Controller\Action;

use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\SyliusStockMovementPlugin\Message\Command\SendReport;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Setono\SyliusStockMovementPlugin\Repository\ReportRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\RouterInterface;

final class SendReportAction
{
    /** @var MessageBusInterface */
    private $commandBus;

    /** @var RouterInterface */
    private $router;

    /** @var FlashBagInterface */
    private $flashBag;

    /** @var ReportRepositoryInterface */
    private $reportRepository;

    public function __construct(
        MessageBusInterface $commandBus,
        RouterInterface $router,
        FlashBagInterface $flashBag,
        ReportRepositoryInterface $reportRepository
    ) {
        $this->commandBus = $commandBus;
        $this->router = $router;
        $this->flashBag = $flashBag;
        $this->reportRepository = $reportRepository;
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

        if ($report->isSuccessful()) {
            $this->commandBus->dispatch(new SendReport($id));

            $this->flashBag->add('success', 'setono_sylius_stock_movement.report_sent');
        } else {
            $this->flashBag->add('error', 'setono_sylius_stock_movement.report_not_sent');
        }

        return new RedirectResponse($this->router->generate('setono_sylius_stock_movement_admin_report_show', ['id' => $id]));
    }
}
