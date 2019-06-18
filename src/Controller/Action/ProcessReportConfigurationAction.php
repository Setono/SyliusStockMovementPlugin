<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Controller\Action;

use Setono\SyliusStockMovementPlugin\Message\Command\ProcessReportConfiguration;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\RouterInterface;

final class ProcessReportConfigurationAction
{
    /** @var MessageBusInterface */
    private $commandBus;

    /** @var RouterInterface */
    private $router;

    /** @var FlashBagInterface */
    private $flashBag;

    public function __construct(
        MessageBusInterface $commandBus,
        RouterInterface $router,
        FlashBagInterface $flashBag
    ) {
        $this->commandBus = $commandBus;
        $this->router = $router;
        $this->flashBag = $flashBag;
    }

    public function __invoke($id)
    {
        $this->commandBus->dispatch(new ProcessReportConfiguration($id));

        $this->flashBag->add('success', 'setono_sylius_stock_movement.report_configuration_processed');

        return new RedirectResponse($this->router->generate('setono_sylius_stock_movement_admin_report_configuration_index'));
    }
}
