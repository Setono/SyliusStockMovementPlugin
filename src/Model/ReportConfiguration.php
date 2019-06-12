<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

use Cron\CronExpression;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ReportConfiguration implements ReportConfigurationInterface
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var CronExpression */
    protected $schedule;

    /** @var string */
    protected $template;

    /** @var ReportConfigurationTransportInterface[]|Collection */
    protected $transports;

    public function __construct()
    {
        $this->transports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSchedule(): ?CronExpression
    {
        return $this->schedule;
    }

    public function setSchedule(CronExpression $schedule): void
    {
        $this->schedule = $schedule;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    public function getTransports(): Collection
    {
        return $this->transports;
    }

    public function hasTransports(): bool
    {
        return !$this->transports->isEmpty();
    }

    public function hasTransport(ReportConfigurationTransportInterface $transport): bool
    {
        return $this->transports->contains($transport);
    }

    public function addTransport(ReportConfigurationTransportInterface $transport): void
    {
        if (!$this->hasTransport($transport)) {
            $transport->setReportConfiguration($this);
            $this->transports->add($transport);
        }
    }

    public function removeTransport(ReportConfigurationTransportInterface $transport): void
    {
        $transport->setReportConfiguration(null);
        $this->transports->removeElement($transport);
    }
}
