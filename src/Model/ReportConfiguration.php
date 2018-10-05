<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

use Cron\CronExpression;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ReportConfiguration implements ReportConfigurationInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var CronExpression
     */
    protected $schedule;

    /**
     * This is the time when the previous run started
     * This way this value can be used as a threshold for future runs
     *
     * @var \DateTime|null
     */
    protected $previousRun;

    /**
     * @var ReportConfigurationDeliveryMethod[]
     */
    protected $deliveryMethods;

    public function __construct()
    {
        $this->deliveryMethods = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getSchedule(): ?CronExpression
    {
        return $this->schedule;
    }

    /**
     * {@inheritdoc}
     */
    public function setSchedule(CronExpression $schedule): void
    {
        $this->schedule = $schedule;
    }

    /**
     * {@inheritdoc}
     */
    public function getPreviousRun(): ?\DateTime
    {
        return $this->previousRun;
    }

    /**
     * {@inheritdoc}
     */
    public function setPreviousRun(?\DateTime $previousRun): void
    {
        $this->previousRun = $previousRun;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeliveryMethods(): Collection
    {
        return $this->deliveryMethods;
    }

    /**
     * {@inheritdoc}
     */
    public function hasDeliveryMethods(): bool
    {
        return !$this->deliveryMethods->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function hasDeliveryMethod(ReportConfigurationDeliveryMethodInterface $reportConfigurationDeliveryMethod): bool
    {
        return $this->deliveryMethods->contains($reportConfigurationDeliveryMethod);
    }

    /**
     * {@inheritdoc}
     */
    public function addDeliveryMethod(ReportConfigurationDeliveryMethodInterface $reportConfigurationDeliveryMethod): void
    {
        if (!$this->hasDeliveryMethod($reportConfigurationDeliveryMethod)) {
            $reportConfigurationDeliveryMethod->setReportConfiguration($this);
            $this->deliveryMethods->add($reportConfigurationDeliveryMethod);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeDeliveryMethod(ReportConfigurationDeliveryMethodInterface $reportConfigurationDeliveryMethod): void
    {
        $reportConfigurationDeliveryMethod->setReportConfiguration(null);
        $this->deliveryMethods->removeElement($reportConfigurationDeliveryMethod);
    }
}
