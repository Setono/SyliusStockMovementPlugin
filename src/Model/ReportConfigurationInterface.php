<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Model;

use Cron\CronExpression;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ReportConfigurationInterface extends ResourceInterface
{
    public function getId(): ?int;

    public function getName(): ?string;

    public function setName(string $name): void;

    public function getSchedule(): ?CronExpression;

    public function setSchedule(CronExpression $schedule): void;

    /**
     * Returns the template identifier
     *
     * @return string
     */
    public function getTemplate(): ?string;

    public function setTemplate(string $template): void;

    public function getDataSource(): ?string;

    public function setDataSource(string $dataSource): void;

    /**
     * @return Collection|ReportConfigurationTransportInterface[]
     */
    public function getTransports(): Collection;

    public function hasTransports(): bool;

    public function hasTransport(ReportConfigurationTransportInterface $transport): bool;

    public function addTransport(ReportConfigurationTransportInterface $transport): void;

    public function removeTransport(ReportConfigurationTransportInterface $rule): void;
}
