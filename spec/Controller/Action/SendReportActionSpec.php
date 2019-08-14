<?php

declare(strict_types=1);

namespace spec\Setono\SyliusStockMovementPlugin\Controller\Action;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Setono\SyliusStockMovementPlugin\Controller\Action\SendReportAction;
use Setono\SyliusStockMovementPlugin\Message\Command\SendReport;
use Setono\SyliusStockMovementPlugin\Model\ReportInterface;
use Setono\SyliusStockMovementPlugin\Repository\ReportRepositoryInterface;
use stdClass;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\RouterInterface;

class SendReportActionSpec extends ObjectBehavior
{
    private const ID = 123;

    public function let(
        MessageBusInterface $commandBus,
        RouterInterface $router,
        FlashBagInterface $flashBag,
        ReportRepositoryInterface $reportRepository
    ): void {
        $router->generate(Argument::type('string'), ['id' => self::ID])->willReturn('route');

        $this->beConstructedWith($commandBus, $router, $flashBag, $reportRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(SendReportAction::class);
    }

    public function it_throws_not_found_exception(ReportRepositoryInterface $reportRepository): void
    {
        $reportRepository->find(self::ID)->willReturn(null);

        $this->shouldThrow(NotFoundHttpException::class)->during('__invoke', [self::ID]);
    }

    public function it_does_not_dispatch_if_report_is_not_successful(ReportRepositoryInterface $reportRepository, ReportInterface $report, MessageBusInterface $commandBus): void
    {
        $reportRepository->find(self::ID)->willReturn($report);
        $report->isSuccessful()->willReturn(false);
        $commandBus->dispatch(Argument::any())->shouldNotBeCalled();

        $this->__invoke(self::ID);
    }

    public function it_dispatches_if_report_is_successful(ReportRepositoryInterface $reportRepository, ReportInterface $report, MessageBusInterface $commandBus): void
    {
        $reportRepository->find(self::ID)->willReturn($report);
        $report->isSuccessful()->willReturn(true);
        $commandBus
            ->dispatch(Argument::type(SendReport::class))
            ->willReturn(new Envelope(new stdClass()))
            ->shouldBeCalled()
        ;

        $this->__invoke(self::ID);
    }
}
