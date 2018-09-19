<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

class ReportConfiguration implements ReportConfigurationInterface
{
    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $type;

    /**
     * @var string|null
     */
    protected $schedule;

    /**
     * @var \DateTime|null
     */
    protected $previousRun;

    /**
     * @var array|null
     */
    protected $criteria;

    /**
     * @var array|null
     */
    protected $deliveryMethods;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
