<?php

namespace Setono\SyliusStockPlugin\Model;

use Cron\CronExpression;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ReportConfigurationInterface extends ResourceInterface
{
    /**
     * @inheritdoc
     */
    public function getId(): ?int;

    /**
     * @return null|string
     */
    public function getName(): ?string;

    /**
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * @return null|string
     */
    public function getType(): ?string;

    /**
     * @param string $type
     */
    public function setType(string $type): void;

    /**
     * @return CronExpression|null
     */
    public function getSchedule(): ?CronExpression;

    /**
     * @param CronExpression $schedule
     */
    public function setSchedule(CronExpression $schedule): void;

    /**
     * @return \DateTime|null
     */
    public function getPreviousRun(): ?\DateTime;

    /**
     * @param \DateTime|null $previousRun
     */
    public function setPreviousRun(?\DateTime $previousRun): void;

    /**
     * @return Collection
     */
    public function getDeliveryMethods(): Collection;

    /**
     * @return bool
     */
    public function hasDeliveryMethods(): bool;

    /**
     * @param ReportConfigurationDeliveryMethodInterface $reportConfigurationDeliveryMethod
     * @return bool
     */
    public function hasDeliveryMethod(ReportConfigurationDeliveryMethodInterface $reportConfigurationDeliveryMethod
    ): bool;

    /**
     * @param ReportConfigurationDeliveryMethodInterface $reportConfigurationDeliveryMethod
     */
    public function addDeliveryMethod(ReportConfigurationDeliveryMethodInterface $reportConfigurationDeliveryMethod
    ): void;

    /**
     * @param ReportConfigurationDeliveryMethodInterface $reportConfigurationDeliveryMethod
     */
    public function removeDeliveryMethod(ReportConfigurationDeliveryMethodInterface $reportConfigurationDeliveryMethod
    ): void;
}